<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251129005554 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE pagamento_venda (id INT AUTO_INCREMENT NOT NULL, venda_id INT NOT NULL, valor DOUBLE PRECISION NOT NULL, tipo_pagamento VARCHAR(50) NOT NULL, INDEX IDX_933E1715924517DF (venda_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE pagamento_venda ADD CONSTRAINT FK_933E1715924517DF FOREIGN KEY (venda_id) REFERENCES venda (id)');
        $this->addSql('ALTER TABLE venda ADD status SMALLINT NOT NULL, DROP valor_pago, DROP forma_pagamento, CHANGE troco valor_desconto DOUBLE PRECISION DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pagamento_venda DROP FOREIGN KEY FK_933E1715924517DF');
        $this->addSql('DROP TABLE pagamento_venda');
        $this->addSql('ALTER TABLE venda ADD valor_pago DOUBLE PRECISION NOT NULL, ADD forma_pagamento VARCHAR(255) NOT NULL, DROP status, CHANGE valor_desconto troco DOUBLE PRECISION DEFAULT NULL');
    }
}
