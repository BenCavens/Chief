<?php namespace Bencavens\Chief\Posts;

interface CommentRepositoryInterface{
	
	public function getAll();

	public function getById( $id );

	public function getAllApproved();

	public function getAllDenied();

	public function getAllPending();

	public function getByPost( $post_id, $status = 'approved' );

	public function getAllByPost( $post_id );
	
}