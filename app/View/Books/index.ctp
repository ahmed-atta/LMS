<h1>Books Lib</h1>
<p><?php 
if (AuthComponent::user('id')){
    echo $this->Html->link('Add Book', array('action' => 'add'));
}
 ?></p>
<table>
    <tr>
        <th>Id</th>
        <th>title</th>
        <th>author name</th>
        <th>Created</th>

        <?php if (AuthComponent::user('id')) :?>
        <th>downloads</th>
        <th>views</th>
        <?php endif; ?>
    </tr>

    

    <?php foreach ($books as $book): ?>
    <tr>
        <td><?php echo $book['Book']['id']; ?></td>
        <td>
            <?php echo $this->Html->link($book['Book']['title'],
            array('controller' => 'books', 'action' => 'view', $book['Book']['id'])); ?>
        </td>
        <td><?php echo $book['Book']['author_name']; ?></td>
        <td>
            <?php echo $book['Book']['created']; ?>
        </td>
        <?php if (AuthComponent::user('id')) : ?>
        <td>
            <?php echo $book['Book']['no_downloads']; ?>
        </td>
        <td>
            <?php echo $book['Book']['no_views']; ?>
        </td>
        <?php endif; ?>
         <td>
            <?php if (AuthComponent::user('id')) {
                    echo $this->Html->link(
                        'Edit',
                        array('action' => 'edit', $book['Book']['id'])
                    );
                }
            ?>
        </td>
       <td>
            <?php if (AuthComponent::user('id')) {
                    echo $this->Form->postLink(
                        'Delete',
                        array('action' => 'delete', $book['Book']['id']),
                        array('confirm' => 'Are you sure?')
                    );
                }
            ?>
            
        </td>
        
    </tr>
    <?php endforeach; ?>
    <?php unset($book); ?>
</table>