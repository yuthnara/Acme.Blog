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

class PostController extends ActionController {

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
	 * @param Blog $blog
	 *
	 * @return void
	 */
	public function indexAction(Blog $blog) {
		$this->view->assign('blog', $blog);
	}

	/**
	 * Displays a single post
	 *
	 * @Flow\IgnoreValidation("$post")
	 * @param Post $post
	 * @return void
	 */
	public function showAction(Post $post) {
		$this->view->assignMultiple([
			'post' => $post,
			'nextPost' => $this->postRepository->findNext($post),
			'previousPost' => $this->postRepository->findPrevious($post),
		]);
	}

	/**
	 * Displays the "Create Post" form
	 *
	 * @param Blog $blog
	 *
	 * @return void
	 */
	public function newAction(Blog $blog) {
		$this->view->assign('blog', $blog);
	}

	/**
	 * Creates a new post
	 *
	 * @param Post $newPost
	 * @return void
	 */
	public function createAction(Post $newPost) {
		$this->postRepository->add($newPost);
		$this->addFlashMessage('Created a new post.');
		$this->redirect('index', NULL, NULL, array('blog' => $newPost->getBlog()));
	}

	/**
	 * Displays the "Edit Post" form
	 *
	 * @Flow\IgnoreValidation("$post")
	 * @param Post $post
	 * @return void
	 */
	public function editAction(Post $post) {
		$this->view->assign('post', $post);
	}

	/**
	 * Updates a post
	 *
	 * @param Post $post
	 * @return void
	 */
	public function updateAction(Post $post) {
		$this->postRepository->update($post);
		$this->addFlashMessage('Updated the post.');
		$this->redirect('index', NULL, NULL, array('blog' => $post->getBlog()));
	}

	/**
	 * Removes a post from the database
	 *
	 * @Flow\IgnoreValidation("$post")
	 * @param Post $post
	 * @return void
	 */
	public function deleteAction(Post $post) {
		$this->postRepository->remove($post);
		$this->addFlashMessage('Deleted a post.');
		$this->redirect('index', NULL, NULL, array('blog' => $post->getBlog()));
	}

}
