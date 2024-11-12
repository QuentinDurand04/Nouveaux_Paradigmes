<?php

namespace iutnc\hellokant\database;

use PDO;
use PDOException;

class Connection
{
    private static ?PDO $pdo = null;

    /**
     * Établit la connexion PDO une seule fois avec les paramètres fournis
     *
     * @param array $conf Tableau contenant les informations de connexion
     * @return PDO Objet PDO représentant la connexion à la base de données
     * @throws PDOException si la connexion échoue
     */
    public static function makeConnection(array $conf): PDO
    {
        if (self::$pdo === null) {
            try {
                $dsn = "mysql:host={$conf['host']};dbname={$conf['dbname']};charset={$conf['charset']}";
                self::$pdo = new PDO(
                    $dsn,
                    $conf['username'],
                    $conf['password'],
                    [
                        PDO::ATTR_PERSISTENT => true,
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_EMULATE_PREPARES => false,
                        PDO::ATTR_STRINGIFY_FETCHES => false,
                    ]
                );
            } catch (PDOException $e) {
                // Gestion des erreurs de connexion
                throw new PDOException("Erreur de connexion : " . $e->getMessage());
            }
        }
        return self::$pdo;
    }

    /**
     * Récupère la connexion PDO si elle a été créée
     *
     * @return PDO|null Objet PDO ou null si la connexion n'a pas été établie
     */
    public static function getConnection(): ?PDO
    {
        return self::$pdo;
    }
}
