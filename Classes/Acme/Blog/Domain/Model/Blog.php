<?php
namespace Acme\Blog\Domain\Model;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Acme.Blog".             *
 *                                                                        *
 *                                                                        */

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use TYPO3\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;

/**
 * A blog that contains a list of posts
 *
 * @Flow\Entity
 */
class Blog {

	/**
	 * @Flow\Validate(type="NotEmpty")
	 * @Flow\Validate(type="StringLength", options={ "minimum"=3, "maximum"=80 })
	 * @ORM\Column(length=80)
	 * @var string
	 */
	protected $title;

	/**
	 * @Flow\Validate(type="StringLength", options={ "maximum"=150 })
	 * @ORM\Column(length=150)
	 * @var string
	 */
	protected $description = '';

	/**
	 * The posts contained in this blog
	 *
	 * @ORM\OneToMany(mappedBy="blog")
	 * @ORM\OrderBy({"date" = "DESC"})
	 * @var Collection<Post>
	 */
	protected $posts;

	/**
	 * @param string $title
	 */
	public function __construct($title) {
		$this->posts = new ArrayCollection();
		$this->title = $title;
	}

	/**
	 * @return string
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * @param string $title
	 * @return void
	 */
	public function setTitle($title) {
		$this->title = $title;
	}

	/**
	 * @return string
	 */
	public function getDescription() {
		return $this->description;
	}

	/**
	 * @param string $description
	 * @return void
	 */
	public function setDescription($description) {
		$this->description = $description;
	}

	/**
	 * @return Collection
	 */
	public function getPosts() {
		return $this->posts;
	}

	/**
	 * Adds a post to this blog
	 *
	 * @param Post $post
	 * @return void
	 */
	public function addPost(Post $post) {
		$this->posts->add($post);
	}

	/**
	 * Removes a post from this blog
	 *
	 * @param Post $post
	 * @return void
	 */
	public function removePost(Post $post) {
		$this->posts->removeElement($post);
	}

}