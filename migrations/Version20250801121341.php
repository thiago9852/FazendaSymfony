<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250801121341 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE fazenda (id INT AUTO_INCREMENT NOT NULL, nome VARCHAR(255) NOT NULL, tamanho DOUBLE PRECISION NOT NULL, responsavel VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_70559C4654BD530C (nome), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fazenda_veterinario (fazenda_id INT NOT NULL, veterinario_id INT NOT NULL, INDEX IDX_4D394109D4A3545F (fazenda_id), INDEX IDX_4D3941091454BD8B (veterinario_id), PRIMARY KEY(fazenda_id, veterinario_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE gado (id INT AUTO_INCREMENT NOT NULL, fazenda_id INT DEFAULT NULL, codigo VARCHAR(255) NOT NULL, peso DOUBLE PRECISION NOT NULL, racao DOUBLE PRECISION NOT NULL, leite DOUBLE PRECISION NOT NULL, nascimento DATE NOT NULL, abate TINYINT(1) DEFAULT NULL, UNIQUE INDEX UNIQ_123C63DB20332D99 (codigo), INDEX IDX_123C63DBD4A3545F (fazenda_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE veterinario (id INT AUTO_INCREMENT NOT NULL, nome VARCHAR(255) NOT NULL, crmv VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_B0490CAD3697FA2C (crmv), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE fazenda_veterinario ADD CONSTRAINT FK_4D394109D4A3545F FOREIGN KEY (fazenda_id) REFERENCES fazenda (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE fazenda_veterinario ADD CONSTRAINT FK_4D3941091454BD8B FOREIGN KEY (veterinario_id) REFERENCES veterinario (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE gado ADD CONSTRAINT FK_123C63DBD4A3545F FOREIGN KEY (fazenda_id) REFERENCES fazenda (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE fazenda_veterinario DROP FOREIGN KEY FK_4D394109D4A3545F');
        $this->addSql('ALTER TABLE fazenda_veterinario DROP FOREIGN KEY FK_4D3941091454BD8B');
        $this->addSql('ALTER TABLE gado DROP FOREIGN KEY FK_123C63DBD4A3545F');
        $this->addSql('DROP TABLE fazenda');
        $this->addSql('DROP TABLE fazenda_veterinario');
        $this->addSql('DROP TABLE gado');
        $this->addSql('DROP TABLE veterinario');
    }
}
