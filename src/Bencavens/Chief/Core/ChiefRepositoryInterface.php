<?php namespace Bencavens\Chief\Core;

/**
 * ---------------------------------------------------------
 * Base Resource interface
 * ---------------------------------------------------------
 *
 * Contract for all chief resources.
 * Developers must implement this interface to all their Chief integrated Repositories
 */

interface ChiefRepositoryInterface{
	
	public function getAll();

	public function getById( $id );
	
}