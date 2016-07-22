<?php
namespace Acme\Blog\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Acme.Blog".             *
 *                                                                        *
 *                                                                        */

use Acme\Blog\Domain\Model\Blog;
use Acme\Blog\Domain\Repository\BlogRepository;
use Acme\Blog\Domain\Repository\PostRepository;
use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Mvc\Controller\ActionController;
use Acme\Blog\Domain\Model\Post;
use TYPO3\Flow\Mvc\View\ViewInterface;

class BlogController extends ActionController {

	/**
	 * @Flow\Inject
	 * @var BlogRepository
	 */
	protected $blogRepository;

	/**
	 * @Flow\Inject
	 * @var PostRepository
	 */
	protected $postRepository;

	/**
	 * @param ViewInterface $view
	 * @return void
	 */
	protected function initializeView(ViewInterface $view) {
	}

	/**
	 * Displays a list of all posts of the current blog
	 *
	 * @return void
	 */
	public function indexAction() {
		$blogs = $this->blogRepository->findAll();
		$this->view->assign('blogs', $blogs);
	}

	/**
	 * Displays a single post
	 *
	 * @Flow\IgnoreValidation("$blog")
	 * @param Blog $blog
	 * @return void
	 */
	public function showAction(Blog $blog) {
		$this->view->assign('blog', $blog);
	}

	/**
	 * Displays the "Create Post" form
	 *
	 * @return void
	 */
	public function newAction() {
	}

	/**
	 * Creates a new blog
	 *
	 * @param Blog $newBlog
	 * @return void
	 */
	public function createAction(Blog $newBlog) {
		$this->blogRepository->add($newBlog);
		$this->addFlashMessage('Created a new blog.');
		$this->redirect('index');
	}

	/**
	 * Displays the "Edit Blog" form
	 *
	 * @Flow\IgnoreValidation("$blog")
	 * @param Blog $blog
	 * @return void
	 */
	public function editAction(Blog $blog) {
		$this->view->assign('blog', $blog);
	}

	/**
	 * Updates a blog
	 *
	 * @param Blog $blog
	 * @return void
	 */
	public function updateAction(Blog $blog) {
		$this->blogRepository->update($blog);
		$this->addFlashMessage('Updated the blog.');
		$this->redirect('index');
	}

	/**
	 * Removes a post from the database
	 *
	 * @Flow\IgnoreValidation("$blog")
	 * @param Blog $blog
	 * @return void
	 */
	public function deleteAction(Blog $blog) {
		$this->blogRepository->remove($blog);
		$this->addFlashMessage('Deleted a blog.');
		$this->redirect('index');
	}

}
