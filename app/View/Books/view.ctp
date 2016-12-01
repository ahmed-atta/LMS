<h3><?php echo h($book['Book']['title']); ?></h3>
<h1><?php echo h($book['Book']['author_name']); ?></h1>

<p></p>
<?php echo $this->Html->image('documents/'. $book['Book']['picture']); ?>
<p><?php echo $this->Html->link("DOWNLOAD",
            array('controller' => 'books', 'action' => 'download', $book['Book']['id'])); ?></p>