<?PHP
    use DynamicalWeb\HTML;

    $RegisterLocation = '/register';
    $PostLocation = '/login';

    if(isset($_GET['redirect']))
    {
        if($_GET['redirect'] == 'purchase_plan')
        {
            if(isset($_GET['type']))
            {
                switch($_GET['type'])
                {
                    case 'free':
                        $RegisterLocation = '/register?redirect=purchase_plan&type=free';
                        $PostLocation = '/login?redirect=purchase_plan&type=free';
                        break;

                    case 'basic':
                        $RegisterLocation = '/register?redirect=purchase_plan&type=basic';
                        $PostLocation = '/login?redirect=purchase_plan&type=basic';
                        break;

                    case 'enterprise':
                        $RegisterLocation = '/register?redirect=purchase_plan&type=enterprise';
                        $PostLocation = '/login?redirect=purchase_plan&type=enterprise';
                        break;
                }
            }
        }

        if($_GET['redirect'] == 'add_balance')
        {
            $RegisterLocation = '/register?redirect=add_balance';
            $PostLocation = '/login?redirect=add_balance';
        }
    }
?>
<h3 class="card-title text-left mb-3"><?PHP HTML::print(TEXT_HEADER); ?></h3>
<?PHP HTML::importScript('callbacks'); ?>
<form action="<?PHP HTML::print($PostLocation, false); ?>" method="POST">
    <div class="form-group">
        <label for="username_email"><?PHP HTML::print(TEXT_FIELD_1); ?></label>
        <input type="text" name="username_email" id="username_email" class="form-control p_input" title="<?PHP HTML::print(TEXT_FIELD_1); ?>">
    </div>
    <div class="form-group">
        <label for="password" ><?PHP HTML::print(TEXT_FIELD_2); ?></label>
        <input type="password" name="password" id="password" class="form-control p_input" title="<?PHP HTML::print(TEXT_FIELD_2); ?>">
    </div>
    <div class="form-group">
        <?PHP HTML::print(re_render(), false); ?>
    </div>
    <div class="text-center">
        <button type="submit" class="btn btn-primary btn-block enter-btn"><?PHP HTML::print(TEXT_SUBMIT_BUTTON); ?></button>
    </div>

    <p class="sign-up"><?PHP HTML::print(TEXT_REGISTER); ?><a href="<?PHP HTML::print($RegisterLocation, false); ?>"> <?PHP HTML::print(TEXT_REGISTER_LINK); ?></a></p>
</form>