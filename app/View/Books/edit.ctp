<h1>Edit book</h1>
<?php
echo $this->Form->create('Book', array('type' => 'file'));
echo $this->Form->input('title');
echo $this->Form->input('author_name');
echo $this->Form->input('picture', array('type' => 'file'));
echo $this->Form->input('download', array('type' => 'file'));
echo $this->Form->select('category_id',$categories,array('default' =>'' ));

echo $this->Form->end('Save book');

?>