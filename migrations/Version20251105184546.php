<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251105184546 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categoria (id INT AUTO_INCREMENT NOT NULL, nome VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cliente (id INT AUTO_INCREMENT NOT NULL, nome VARCHAR(255) NOT NULL, cpf VARCHAR(255) NOT NULL, email VARCHAR(255) DEFAULT NULL, telefone VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE produto (id INT AUTO_INCREMENT NOT NULL, categoria_id INT NOT NULL, nome VARCHAR(255) NOT NULL, descricao VARCHAR(255) DEFAULT NULL, quantidade_inicial INT NOT NULL, quantidade_estoque INT NOT NULL, INDEX IDX_5CAC49D73397707A (categoria_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE venda (id INT AUTO_INCREMENT NOT NULL, cliente_id INT NOT NULL, usuario_id INT NOT NULL, data_venda DATE NOT NULL, valor_total DOUBLE PRECISION NOT NULL, valor_pago DOUBLE PRECISION NOT NULL, forma_pagamento VARCHAR(255) NOT NULL, troco DOUBLE PRECISION DEFAULT NULL, INDEX IDX_C525FC04DE734E51 (cliente_id), INDEX IDX_C525FC04DB38439E (usuario_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE venda_item (id INT AUTO_INCREMENT NOT NULL, venda_id INT NOT NULL, produto_id INT NOT NULL, quantidade INT NOT NULL, valor_atual_produto DOUBLE PRECISION NOT NULL, INDEX IDX_F305FDDA924517DF (venda_id), INDEX IDX_F305FDDA105CFD56 (produto_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE produto ADD CONSTRAINT FK_5CAC49D73397707A FOREIGN KEY (categoria_id) REFERENCES categoria (id)');
        $this->addSql('ALTER TABLE venda ADD CONSTRAINT FK_C525FC04DE734E51 FOREIGN KEY (cliente_id) REFERENCES cliente (id)');
        $this->addSql('ALTER TABLE venda ADD CONSTRAINT FK_C525FC04DB38439E FOREIGN KEY (usuario_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE venda_item ADD CONSTRAINT FK_F305FDDA924517DF FOREIGN KEY (venda_id) REFERENCES venda (id)');
        $this->addSql('ALTER TABLE venda_item ADD CONSTRAINT FK_F305FDDA105CFD56 FOREIGN KEY (produto_id) REFERENCES produto (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE produto DROP FOREIGN KEY FK_5CAC49D73397707A');
        $this->addSql('ALTER TABLE venda DROP FOREIGN KEY FK_C525FC04DE734E51');
        $this->addSql('ALTER TABLE venda DROP FOREIGN KEY FK_C525FC04DB38439E');
        $this->addSql('ALTER TABLE venda_item DROP FOREIGN KEY FK_F305FDDA924517DF');
        $this->addSql('ALTER TABLE venda_item DROP FOREIGN KEY FK_F305FDDA105CFD56');
        $this->addSql('DROP TABLE categoria');
        $this->addSql('DROP TABLE cliente');
        $this->addSql('DROP TABLE produto');
        $this->addSql('DROP TABLE venda');
        $this->addSql('DROP TABLE venda_item');
    }
}
