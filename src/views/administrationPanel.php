<div id = "header">
    Administration Panel
</div>

<div id="table">
    <div id="header-row" class="user-row">
        <span class="row-element">ID</span>
        <span class="row-element">Login</span>
        <span class="row-element">E-mail</span>
        <span class="row-element">Enabled</span>
        <span class="row-element">Role</span>
        <span class="row-element">
            Delete
<!--            <img src="../../public/images/delete_button.svg">-->
        </span>
    </div>

    <?php foreach($variables['users'] as $user):?>
        <div class="user-row">
            <span class="row-element"><?php echo $user->getId(); ?></span>
            <span class="row-element"><?php echo $user->getLogin(); ?></span>
            <span class="row-element"><?php echo $user->getEmail(); ?></span>
            <span class="row-element"><?php echo $user->isEnabled(); ?></span>
            <span class="row-element"><?php echo $user->getRole(); ?></span>
            <span class="row-element">
                <img src="../../public/images/delete_button.svg">
            </span>
        </div>


    <?php endforeach;?>


</div>