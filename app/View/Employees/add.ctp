<h1>Add Employee</h1>

<?php echo $this->Form->create('Employee', array('type' => 'file')); ?>

<div class="form-group">
	<label>Employee Name:</label>
	<?php echo $this->Form->input('name', array('label' => false, 'class' => 'form-control')); ?>
</div>
<div class="form-group">
	<label>Employee Address:</label>
	<?php echo $this->Form->textarea('address', array('label' => false, 'class' => 'form-control')); ?>
</div>
<div class="form-group">
	<label>Employee Email:</label>
	<?php echo $this->Form->email('email', array('label' => false, 'class' => 'form-control')); ?>
</div>
<div class="form-group">
	<label>Employee Phone:</label>
	<?php echo $this->Form->input('phone', array('type' => 'text', 'pattern'=>"[0-9]{10}", "title" => "Phone number accepts only numeric value", 'label' => false, 'class' => 'form-control')); ?>
</div>
<div class="form-group">
	<label>Employee date of birth:</label>
	<?php echo $this->Form->date('dob', array('label' => false, 'class' => 'form-control', 'max' => date('Y-m-d'))); ?>
</div>
<div class="form-group">
	<label>Select Picture:</label>
	<?php echo $this->Form->file('pic', array('label' => false, 'class' => 'form-control')); ?>
</div>

<?php echo $this->Form->submit('Save employee', array('class' => 'btn btn-primary')); ?>

<?php echo $this->Form->end(); ?>