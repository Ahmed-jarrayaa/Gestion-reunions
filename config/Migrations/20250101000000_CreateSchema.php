<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateSchema extends AbstractMigration
{
    private array $legacy = [
        'fonctions',
        'utilisateurs',
        'reunions',
        'participants',
        'planification',
        'participants_planifications',
        'types_reunions',
    ];

    public function up(): void
    {
        foreach ($this->legacy as $name) {
            if (!$this->hasTable($name)) {
                $this->execute($this->createSql($name));
            }
        }
    }

    public function down(): void
    {
        foreach (array_reverse($this->legacy) as $name) {
            if ($this->hasTable($name)) {
                $this->execute('DROP TABLE `' . $name . '`');
            }
        }
    }

    private function createSql(string $name): string
    {
        $tables = [
            'fonctions' => "CREATE TABLE `fonctions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1",

            'utilisateurs' => "CREATE TABLE `utilisateurs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `role` enum('admin','membre') DEFAULT 'membre',
  `mot_de_passe` varchar(255) NOT NULL,
  `fonction_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `fk_utilisateurs_fonctions` (`fonction_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1",

            'reunions' => "CREATE TABLE `reunions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `date_heure` datetime NOT NULL,
  `lieu` varchar(255) DEFAULT NULL,
  `statut` varchar(50) DEFAULT NULL,
  `cree_par` int(11) DEFAULT NULL,
  `id_type` int(11) DEFAULT NULL,
  `participants_attente` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cree_par` (`cree_par`),
  KEY `id_type` (`id_type`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1",

            'participants' => "CREATE TABLE `participants` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_reunion` int(11) DEFAULT NULL,
  `id_utilisateur` int(11) DEFAULT NULL,
  `presence` enum('oui','non','en_attente') DEFAULT 'en_attente',
  `id_planification` int(11) DEFAULT NULL,
  `statut` varchar(50) DEFAULT 'en_attente',
  PRIMARY KEY (`id`),
  KEY `id_reunion` (`id_reunion`),
  KEY `id_utilisateur` (`id_utilisateur`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1",

            'planification' => "CREATE TABLE `planification` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) NOT NULL,
  `date_planification` datetime NOT NULL,
  `lieu` varchar(255) NOT NULL,
  `cree_par` int(11) NOT NULL,
  `id_type` int(11) NOT NULL,
  `statut` enum('en_attente','accepte','refuse') DEFAULT 'en_attente',
  `planifie_par` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cree_par` (`cree_par`),
  KEY `id_type` (`id_type`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1",

            'participants_planifications' => "CREATE TABLE `participants_planifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_planification` int(11) NOT NULL,
  `id_utilisateur` int(11) NOT NULL,
  `presence` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `id_planification` (`id_planification`),
  KEY `id_utilisateur` (`id_utilisateur`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1",

            'types_reunions' => "CREATE TABLE `types_reunions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom_type` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1",
        ];

        return $tables[$name] ?? '';
    }
}