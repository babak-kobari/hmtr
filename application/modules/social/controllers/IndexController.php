<?php

//require_once 'Wall.php';
class Social_IndexController extends Zend_Controller_Action {
	
	private $_logedInUser;
	
	private $_loginName ;
	
	public function init () {
		$identity = Zend_Auth::getInstance()->getIdentity();
		if ($identity == null) {
			$this->_redirect("/login");
		}else {
			$this->_logedInUser = $identity->id;
			$this->_loginName = $identity->login;
		}
		
	}
	public function indexAction () {
		
		
	}
	public function posttowallAction () {
		
	}
	public function getmywallAction () {
		try{
			$modelWall = new Social_Model_Wall();
			//$modelWall->publishToWall(6);
			$myWallPosts =  $modelWall->getmywall($this->_logedInUser);
			//echo json_encode($myWallPosts);exit;
			if (count($myWallPosts) > 0) {
				$outStr = "";
				foreach ($myWallPosts as $mywall) {
					$outStr .= " <div class='artcle-bx  brd-01 to-padd-05'> ";
						$outStr .= "<div class='profile-img to-left'>";
							$outStr .= "<a href='profile-other.html'>";
								if ($mywall['avatar'] !=""){
									$outStr .= "<img src='".$mywall['avatar']."' width='48' height='48' alt='photo'/>";
								}else {
									$outStr .= "<img src='wall/images/smll-no-photo.jpg' width='48' height='48' alt='photo'/>";
								}
								
							$outStr .= "</a> ";
						$outStr .= "</div> ";
						$outStr .= "<div class=\"poll-01 to-left\">";
							$outStr .="<span class=\"blk pad-16 pollspan\">";
								$outStr .= "<span class=\"name-01\">";
									$outStr .="<a href=\"javascript:void(0);\">".ucfirst($mywall['username'])."</a>          ";
									$outStr  .= "<time>".$mywall['post_created']."</time>";
								$outStr .= "</span> ";
							$outStr .= "</span> ";
							$outStr .= "<h5>".$mywall['exp_title']."</h5>";
							$outStr .="<div class=\"detail-hldr\">".ucfirst($mywall['username'])." visited ".ucfirst($mywall['city_visted'])."</div>";
						$outStr .= "</div> ";
					
					
					
						$outStr .= '<span class="actionLinks">';
						$outStr .= '<span><a href="#">Like</a></span>';
						$outStr .= '<label><a href="#">Coment</a></label>';
						$outStr .= '</span>';
					
						$outStr .= "<div class='post-cmnt-box clearfix' >";
							$outStr .= "<div class='post-cmnt-box-inr'>";
								$outStr .= "<span class=\"pointer\"></span>";
								$outStr .="<div class=\"cmt-listing\" id='wall_".$mywall['wall_id']."'>";
								$outStr .= "<ul>";
								
									/* $outStr .= "<li>";
										$outStr .= "<div>";
											$outStr .= "<blockquote>";
												$outStr .="<p>This morning I got an e-mail from someone asking for some pointers on how to build a successul open source project. </p>";
												$outStr .= "<h5><a href=\"#\">Zerra Hoff</a> <time>   &nbsp;&nbsp;&nbsp;&nbsp;2 hr ago</time></h5>";
												$outStr .= "<span class=\"clr\"></span>";
											$outStr .= "</blockquote>";
										$outStr .= "</div>";
									$outStr .= "</li>"; */
									
								if (isset($mywall['comment_message']))	{
									//echo "<pre>";print_r($mywall['comment_message']);exit;
									foreach ($mywall['comment_message'] as $comments) {
										$outStr .= "<li>";
											$outStr .= "<div>";
												$outStr .= "<blockquote>";
													$outStr .="<p>".$comments['message']."</p>";
													$outStr .= "<h5><a href=\"#\">".$comments['username']."</a> <time>   &nbsp;&nbsp;&nbsp;&nbsp;".$comments['comm_created']." </time></h5>";
													$outStr .= "<span class=\"clr\"></span>";
												$outStr .= "</blockquote>";
											$outStr .= "</div>";
										$outStr .= "</li>";
													
											
									}	
								}
									
									
								$outStr .= "</ul>";
								$outStr .= "</div> ";
								$outStr .= "<fieldset class=\"comment-bx\" >";
									$outStr .= "<textarea  class='autogrow' id='com_wall_".$mywall['wall_id']."'>Post your comment</textarea>";
								$outStr .= "</fieldset>";
							$outStr .= "</div> ";
						$outStr .= "</div> ";
					
					$outStr .= "</div> ";
					
				}
				echo $outStr;exit;
				
			}
			
			//echo "<pre>";print_r($myWallPosts);exit;
		}catch (Exception $e) {
			print $e->getMessage();
		}
		exit;
	}

	
	public function postcommentAction () {
		$request = $this->getRequest ();
		$outStr = "";
		if($request->isPost()) {
			$comment = $request->getParam('cmt');
			$wallId = $request->getParam('w');
			$modelWall = new Social_Model_Wall();
			$modelWall->postComment($this->_logedInUser, $wallId, $comment);
			$outStr .= "<li>";
			$outStr .= "<div>";
			$outStr .= "<blockquote>";
			$outStr .="<p>".$comment."</p>";
			$outStr .= "<h5><a href=\"#\">".$this->_loginName."</a> </h5>";
			$outStr .= "<span class=\"clr\"></span>";
			$outStr .= "</blockquote>";
			$outStr .= "</div>";
			$outStr .= "</li>";
				
		}
		echo $outStr;exit;
	}

	public function loadunfollowusersAction () {
		$modelWall = new Social_Model_Wall();
		$userList = $modelWall->getunfollowUsers($this->_logedInUser);
		echo json_encode($userList);exit;
	}
	public function followuserAction () {
		
		$request = $this->getRequest ();
		if($request->isPost()) {
			$followuser = $request->getParam('u');
			$modelWall = new Social_Model_Wall();
			$modelWall->followUser($this->_logedInUser, $followuser);
			
		}
		exit;
	}
}