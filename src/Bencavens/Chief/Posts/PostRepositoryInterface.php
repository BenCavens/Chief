<?php namespace Bencavens\Chief\Posts;

interface PostRepositoryInterface{
	
	public function getAll();

	public function getById( $id );

	public function getBySlug( $slug );

	public function getAllPublished();

	public function getAllDraft();

	public function getAllArchived();

	public function getByAuthor( $author_id );

	public function getPopular();

	public function getVersionsById( $id );

	public function getByTag( $tag_id );

	public function getByTags( array $tag_ids );

	public function getByCategory( $category_id );

	public function getByCategories( array $category_ids );
}