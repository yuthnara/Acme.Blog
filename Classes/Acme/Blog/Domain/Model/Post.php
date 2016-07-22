<?php
namespace Acme\Blog\Domain\Model;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Acme.Blog".             *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;

/**
 * @Flow\Entity
 */
class Post {

	/**
	 * @Flow\Validate(type="NotEmpty")
	 * @ORM\ManyToOne(inversedBy="posts")
	 * @var Blog
	 */
	protected $blog;

	/**
	 * @Flow\Validate(type="NotEmpty")
	 * @Flow\Validate(type="StringLength", options={ "minimum"=3, "maximum"=50 })
	 * @var string
	 */
	protected $subject;

	/**
	 * The creation date of this post (set in the constructor)
	 *
	 * @var \DateTime
	 */
	protected $date;

	/**
	 * @Flow\Validate(type="NotEmpty")
	 * @var string
	 */
	protected $author;

	/**
	 * @Flow\Validate(type="NotEmpty")
	 * @ORM\Column(type="text")
	 * @var string
	 */
	protected $content;

	/**
	 * Constructs this post
	 */
	public function __construct() {
		$this->date = new \DateTime();
	}

	/**
	 * @return Blog
	 */
	public function getBlog() {
		return $this->blog;
	}

	/**
	 * @param Blog $blog
	 * @return void
	 */
	public function setBlog(Blog $blog) {
		$this->blog = $blog;
		$this->blog->addPost($this);
	}

	/**
	 * @return string
	 */
	public function getSubject() {
		return $this->subject;
	}

	/**
	 * @param string $subject
	 * @return void
	 */
	public function setSubject($subject) {
		$this->subject = $subject;
	}

	/**
	 * @return \DateTime
	 */
	public function getDate() {
		return $this->date;
	}

	/**
	 * @param \DateTime $date
	 * @return void
	 */
	public function setDate(\DateTime $date) {
		$this->date = $date;
	}

	/**
	 * @return string
	 */
	public function getAuthor() {
		return $this->author;
	}

	/**
	 * @param string $author
	 * @return void
	 */
	public function setAuthor($author) {
		$this->author = $author;
	}

	/**
	 * @return string
	 */
	public function getContent() {
		return $this->content;
	}

	/**
	 * @param string $content
	 * @return void
	 */
	public function setContent($content) {
		$this->content = $content;
	}

}