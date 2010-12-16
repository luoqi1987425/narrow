<?php 
	interface Narrow_Message_Interface{
		
		
		public function save( $data );
		
		public function delete( $id );
		
		public function getsRssOutput( $sign );
		
		public function getById( $id );
		
		public function gets( $conditons = null , $order = null , $pageNo = null , $pageSize = null );
		
		public function getsCount( $conditons = null );
	}
?>