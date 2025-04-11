<?php

namespace App\Models;

use app\Core\Database;

abstract class Model extends Database
{
    protected ?string $table = null;
    protected ?Database $db = null;

    public function find(int $id): bool|object
    {
        $pdoStatement = $this->runQuery(/** @lang text */ "SELECT * FROM {$this->table} WHERE id = :id",
            ['id' => $id])
            ->fetch();

        return $this->fetchHydrate($pdoStatement);


    }

    public function findAll(): array
    {
        $pdoStatement = $this
            ->runQuery(/** @lang text */ "SELECT * FROM $this->table")
            ->fetchAll();
        return $this->fetchHydrate($pdoStatement);
    }

    public function findBy(array $filters): array
    {
        // On crée un tableau vide qui va stocker les champs avec les markers SQL
        $champs = [];
        //On crée un tableau vide qui va stocker les valeurs (tableau associatif execute)
        $params = [];
        //On boucle sur le tableau qui stock les filtres
        foreach ($filters as $champ => $valeur) {
            // On ajoute le champ avec le marker SQL
            $champs[] = "$champ = :$champ";
            //On ajoute la valeur dans le tableau des valeurs
            $params[$champ] = $valeur;
        }

        $listeChamps = implode(" AND ", $champs);

        //on execute la requete

        $pdoStatement = $this
            ->runQuery(/** @lang text */ "SELECT * FROM $this->table WHERE $listeChamps", $params)
            ->fetchAll();

        return $this->fetchHydrate($pdoStatement);
    }

    public function create(): ?\PDOStatement
    {
        // INSERT INTO postes (title, description, enabled) VaLUES (:title, :description, :enables)
        $champs = [];
        $params = [];
        $markers = [];

        foreach ($this as $champ => $valeur) {
            if ($champ === 'db' || $champ === 'table' || $valeur === null) {
                continue;
            }
            $champs[] = $champ;
            $markers[] = ":$champ";
            // On gère les contextes particuliers entre PHP et MYSQL
            if (gettype($valeur) === 'boolean') {
                $valeur = (int)$valeur;
            } else if (gettype($valeur) === 'array') {
                $valeur = json_encode($valeur);

            } else if ($valeur instanceof \DateTime) {
                $valeur = $valeur->format('Y-m-d H:i:s');
            }
            $params[$champ] = $valeur;
        }
        var_dump($champs, $markers, $params);

        $listeChamps = implode(", ", $champs);
        $listeMarkers = implode(", ", $markers);

        return $this
            ->runQuery(
            /** @lang text */ "INSERT INTO $this->table($listeChamps) VALUES($listeMarkers)",
                $params,
            );
    }


    public function update(): ?\PDOStatement
    {
        //UPDATE postes SET title =:title, description = :description, enabled = :enabled WHERE id = :id
        $champs = [];
        $params = [];
        foreach ($this as $champ => $valeur) {
            if ($champ === 'db' || $champ === 'table' || $valeur === null || $champ === 'id') {
                continue;
            }
            $champs[] = "$champ = :$champ";

            // On gère les contextes particuliers entre PHP et MYSQL
            if (gettype($valeur) === 'boolean') {
                $valeur = (int)$valeur;
            } else if (gettype($valeur) === 'array') {
                $valeur = json_encode($valeur);

            } else if ($valeur instanceof \DateTime) {
                $valeur = $valeur->format('Y-m-d H:i:s');
            }

            $params[$champ] = $valeur;
        }
        $listeChamps = implode(", ", $champs);
        var_dump($listeChamps, $params);

        if (!empty($this->id)) {
            $params['id'] = $this->id;
        }

        return $this->runQuery(/** @lang text */ "UPDATE $this->table SET $listeChamps WHERE id = :id ", $params);

    }


    public function delete(): ?\PDOStatement
    {

        // DELETE FROM postes WHERE id = :id
        return $this
            ->runQuery(/** @lang text */ "DELETE FROM $this->table WHERE id = :id", ['id' => $this->id]);
    }


    public function hydrate(array|object $data): static
    {
        // On boucle sur le tableau de données
        foreach ($data as $key => $valeur) {
            $method = "set" . ucfirst($key);

            if (method_exists($this, $method)) {
                // On vérifie si c'est le champ ceatedAt = création d'un objet Datetime
                if ($key === 'createdAt') {
                    $valeur = new \DateTime($valeur);
                }
                $this->$method($valeur);
            }
        }
        return $this;
    }


    public function fetchHydrate(mixed $query): static|array|bool
    {
        var_dump($query);

        if (is_array($query) && count($query) > 0) {
            // Boucle sur le tableau de résultats pour instancier chaque objet
            //foreach --> code junior
//            $data = [];
//            foreach ($query as $object) {
//                $data[] = (new static())->hydrate($object);
//            }
//            return $data;
            // code avec arraymap
            return array_map(function ($object): static {
                return (new static())->hydrate($object);
            }, $query);

            // On vérifie si $query est un objet
        } else if (is_object($query)) {
            // On a un objet standard -> on instancie  un objet de la classe et on hydrate
            return (new static())->hydrate($query);
        } else {
            return $query;
        }

    }


    // Sert juste a verifier si c'est préparé ou non
    protected function runQuery(string $sql, ?array $params = null): ?\PDOStatement
    {
        // On récupére la connexion en BDD
        $this->db = Database::getInstance();
        //On vérifie si la requête est préparée ou non
        if ($params !== null) {
            // Requête préparée
            $query = $this->db->prepare($sql);
            // On exécute la requête
            $query->execute($params);
            return $query;
        } else {
            return $this->db->query($sql);
        }
    }
}