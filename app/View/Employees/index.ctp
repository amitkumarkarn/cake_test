<div class="d-flex justify-content-between my-3">
	List Employees
	<div>
		<?php echo $this->Html->link('Search Employee', array('controller' => 'employees', 'action' => 'search'), array('class' => 'btn btn-success btn-sm')); ?>
		<?php echo $this->Html->link('Add Employee', array('controller' => 'employees', 'action' => 'add'), array('class' => 'btn btn-primary btn-sm')); ?>
	</div>
</div>

<table class="table table-bordered">
	<thead>
		<tr>
			<th scope="col">#</th>
			<th scope="col">Name</th>
			<th scope="col">Email</th>
			<th scope="col">Phone</th>
			<th scope="col">Address</th>
			<th scope="col">Birth date</th>
			<th scope="col" width="15%">Image</th>
			<th scope="col" width="15%">Action</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		$count = $this->Paginator->counter(array('format' => '{:start}'));
		foreach($lists as $list) { $img = $list['Employee']['pic']; ?>
			<tr>
				<td><?= $count; ?></td>
				<td><?= $list['Employee']['name']; ?></td>
				<td><?= $list['Employee']['email']; ?></td>
				<td><?= $list['Employee']['phone']; ?></td>
				<td><?= $list['Employee']['address']; ?></td>
				<td><?= $list['Employee']['dob']; ?></td>
				<td><img src="<?php echo $this->webroot.'img/emp/'.$img ?>" class="img-thumbnail" width="80" height="120" ></td>
				<td>
					<?php echo $this->Html->link('Edit', array('controller' => 'employees', 'action' => 'edit', $list['Employee']['id']), array('class' => 'btn btn-primary btn-sm')); ?>
					<?php echo $this->Form->postLink('Delete', array('controller' => 'employees', 'action' => 'delete', $list['Employee']['id']), array('confirm' => 'Are you sure?', 'class' => 'btn btn-danger btn-sm')); ?>
				</td>
			</tr>
		<?php $count++; } ?>
	</tbody>
</table>

<div class="row">
		<div class="col-sm-12 p-0 mb-2">
            <div class="pagination mt-3">
                <div class="d-flex justify-content-between text-muted w-100">
                        <ul class="pagination">
                            <?php
                                echo $this->Paginator->prev('< ' . __('Previous'), array('tag' => 'li', 'class'=>'page-item', ' class'=>'page-link'), null, array('class' => 'disabled page-item', 'tag' => 'li', 'disabledTag' => 'a', ' class' =>'page-link'));
                                
                                echo $this->Paginator->numbers(array('separator' => '', 'currentTag' => 'a', 'tag' => 'li', 'class'=>'page-item',  'currentClass' => 'disabled page-link', ' class'=>'page-link'));

                                echo $this->Paginator->next(__('Next') . ' >', array('tag' => 'li', 'class'=>'page-item', ' class'=>'page-link'), null, array('class' => 'disabled page-item', 'tag' => 'li', 'disabledTag' => 'a', 'currentClass'=>'page-link', ' class' =>'page-link'));
                            ?>
                        </ul>
                </div>
            </div>
        </div>
    </div>