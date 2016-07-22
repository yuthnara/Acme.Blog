<?php
namespace TYPO3\Flow\Persistence\Doctrine\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
	Doctrine\DBAL\Schema\Schema;

/**
 * Initial migration, creating tables for the "Blog" and "Post" domain models
 */
class Version20150714161019 extends AbstractMigration {

	/**
	 * @param Schema $schema
	 * @return void
	 */
	public function up(Schema $schema) {
		$this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql");

		$this->addSql("CREATE TABLE acme_blog_domain_model_blog (persistence_object_identifier VARCHAR(40) NOT NULL, title VARCHAR(80) NOT NULL, description VARCHAR(150) NOT NULL, PRIMARY KEY(persistence_object_identifier)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
		$this->addSql("CREATE TABLE acme_blog_domain_model_post (persistence_object_identifier VARCHAR(40) NOT NULL, blog VARCHAR(40) DEFAULT NULL, subject VARCHAR(255) NOT NULL, date DATETIME NOT NULL, author VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, INDEX IDX_EF2000AAC0155143 (blog), PRIMARY KEY(persistence_object_identifier)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
		$this->addSql("ALTER TABLE acme_blog_domain_model_post ADD CONSTRAINT FK_EF2000AAC0155143 FOREIGN KEY (blog) REFERENCES acme_blog_domain_model_blog (persistence_object_identifier)");
	}

	/**
	 * @param Schema $schema
	 * @return void
	 */
	public function down(Schema $schema) {
		$this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql");

		$this->addSql("ALTER TABLE acme_blog_domain_model_post DROP FOREIGN KEY FK_EF2000AAC0155143");
		$this->addSql("DROP TABLE acme_blog_domain_model_blog");
		$this->addSql("DROP TABLE acme_blog_domain_model_post");
	}
}