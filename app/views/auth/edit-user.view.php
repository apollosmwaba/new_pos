<?php

if(!empty($_SESSION['referer'])){
	$back_link = $_SESSION['referer'];
}else{
	$back_link = "index.php?pg=admin&tab=users";
}

?>

<?php require views_path('partials/header');?>

	<div class="container-fluid border col-lg-5 col-md-6 mt-5 p-4" >
		
		<?php if(is_array($row)):?>
		<form method="post">
			<center>
				<h3><i class="fa fa-user"></i> Edit User</h3>
				<div><?=esc(APP_NAME)?></div>
			</center>
			<br>
			<div class="mb-3">
				<label class="form-label">Username</label>
				<input value="<?=set_value('username',$row['username'])?>" name="username" type="text" class="form-control <?=!empty($errors['username']) ? 'border-danger':''?>" placeholder="Username">
				<?php if(!empty($errors['username'])):?>
					<small class="text-danger"><?=$errors['username']?></small>
				<?php endif;?>
			</div>
			<div class="mb-3">
				<label class="form-label">Email address</label>
				<input value="<?=set_value('email',$row['email'])?>" name="email" type="email" class="form-control <?=!empty($errors['email']) ? 'border-danger':''?>" placeholder="name@example.com">
				<?php if(!empty($errors['email'])):?>
					<small class="text-danger"><?=$errors['email']?></small>
				<?php endif;?>
			</div>
			<div class="mb-3">
				<label class="form-label">Gender</label>
				<select name="gender" class="form-control <?=!empty($errors['gender']) ? 'border-danger':''?>">
					<option value="">Select gender</option>
					<option value="male" <?=set_value('gender',$row['gender'])=='male'?'selected':''?>>Male</option>
					<option value="female" <?=set_value('gender',$row['gender'])=='female'?'selected':''?>>Female</option>
				</select>
				<?php if(!empty($errors['gender'])):?>
					<small class="text-danger"><?=$errors['gender']?></small>
				<?php endif;?>
			</div>
			<?php if(Auth::get('role') == "admin"):?>
			<div class="mb-3">
				<label class="form-label">Role</label>
				<select name="role" class="form-control <?=!empty($errors['role']) ? 'border-danger':''?>">
					<option value="">Select role</option>
					<option value="admin" <?=set_value('role',$row['role'])=='admin'?'selected':''?>>Admin</option>
					<option value="supervisor" <?=set_value('role',$row['role'])=='supervisor'?'selected':''?>>Supervisor</option>
					<option value="cashier" <?=set_value('role',$row['role'])=='cashier'?'selected':''?>>Cashier</option>
					<option value="user" <?=set_value('role',$row['role'])=='user'?'selected':''?>>User</option>
				</select>
				<?php if(!empty($errors['role'])):?>
					<small class="text-danger"><?=$errors['role']?></small>
				<?php endif;?>
			</div>
			<?php endif;?>
			<div class="input-group mb-3">
				<span class="input-group-text">Password</span>
				<input value="<?=set_value('password','')?>" name="password" type="password" class="form-control <?=!empty($errors['password']) ? 'border-danger':''?>" placeholder="Password (leave empty to not change)">
				<?php if(!empty($errors['password'])):?>
					<small class="text-danger col-12"><?=$errors['password']?></small>
				<?php endif;?>
			</div>
			<div class="input-group mb-3">
				<span class="input-group-text">Retype Password</span>
				<input value="<?=set_value('password_retype','')?>" name="password_retype" type="password" class="form-control <?=!empty($errors['password_retype']) ? 'border-danger':''?>" placeholder="Retype Password (leave empty to not change)">
				<?php if(!empty($errors['password_retype'])):?>
					<small class="text-danger col-12"><?=$errors['password_retype']?></small>
				<?php endif;?>
			</div>
			<br>
			<button class="btn btn-primary float-end">Save</button>
			<a href="<?=$back_link?>">
				<button type="button" class="btn btn-danger">Cancel</button>
			</a>
			<div class="clearfix"></div>
		</form>
		<?php else:?>
			<div class="alert alert-danger text-center">That user was not found!</div>
			<a href="<?=$back_link?>">
				<button type="button" class="btn btn-danger">Cancel</button>
			</a>
		<?php endif;?>
	</div>

<?php require views_path('partials/footer');?>
