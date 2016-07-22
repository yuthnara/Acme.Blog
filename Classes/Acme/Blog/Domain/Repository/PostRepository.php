<?php
namespace Acme\Blog\Domain\Repository;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Acme.Blog".             *
 *                                                                        *
 *                                                                        */

use Acme\Blog\Domain\Model\Blog;
use Acme\Blog\Domain\Model\Post;
use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Persistence\QueryInterface;
use TYPO3\Flow\Persistence\QueryResultInterface;
use TYPO3\Flow\Persistence\Repository;

/**
 * @Flow\Scope("singleton")
 */
class PostRepository extends Repository {

	/**
	 * Finds posts by the specified blog
	 *
	 * @param Blog $blog The blog the post must refer to
	 * @return QueryResultInterface The posts
	 */
	public function findByBlog(Blog $blog) {
		$query = $this->createQuery();
		return
			$query->matching(
				$query->equals('blog', $blog)
			)
			->setOrderings(array('date' => QueryInterface::ORDER_DESCENDING))
			->execute();
	}

	/**
	 * Finds the previous of the given post
	 *
	 * @param Post $post The reference post
	 * @return Post
	 */
	public function findPrevious(Post $post) {
		$query = $this->createQuery();
		return
			$query->matching(
				$query->logicalAnd([
					$query->equals('blog', $post->getBlog()),
					$query->lessThan('date', $post->getDate())
				])
			)
			->setOrderings(array('date' => QueryInterface::ORDER_DESCENDING))
			->execute()
			->getFirst();
	}

	/**
	 * Finds the post next to the given post
	 *
	 * @param Post $post The reference post
	 * @return Post
	 */
	public function findNext(Post $post) {
		$query = $this->createQuery();
		return
			$query->matching(
				$query->logicalAnd([
					$query->equals('blog', $post->getBlog()),
					$query->greaterThan('date', $post->getDate())
				])
			)
			->setOrderings(array('date' => QueryInterface::ORDER_ASCENDING))
			->execute()
			->getFirst();
	}

}