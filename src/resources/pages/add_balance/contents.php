<?PHP
    /** @noinspection PhpUnhandledExceptionInspection */

    use DynamicalWeb\HTML;

    HTML::importScript('check_auth');
    HTML::importScript('require_authentication');
    HTML::importScript('cache');

?>
<!DOCTYPE html>
<html lang="<?PHP HTML::print(APP_LANGUAGE_ISO_639); ?>">
    <head>
        <?PHP HTML::importSection('header'); ?>
        <title><?PHP HTML::print(TEXT_PAGE_TITLE); ?></title>
    </head>

    <body<?PHP HTML::print(SIDEBAR_STATE, false); ?>>

        <div class="container-scrollbar">
            <?PHP HTML::importSection('navigation'); ?>
            <div class="container-fluid page-body-wrapper">
                <?PHP HTML::importSection('sidebar'); ?>
                <div class="main-panel">
                    <div class="content-wrapper">

                        <div class="row grid-margin">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="card-title"><?PHP HTML::print(TEXT_CARD_HEADER); ?></div>

                                        <p><?PHP HTML::print(TEXT_FAQ_HEADER); ?></p>
                                        <div class="accordion" id="accordion" role="tablist">

                                            <div class="card">
                                                <div class="card-header" role="tab" id="faq-h1">
                                                    <h5 class="mb-0">
                                                        <a data-toggle="collapse" href="#faq-1" aria-expanded="false" aria-controls="faq-1">
                                                            How does this work?
                                                        </a>
                                                    </h5>
                                                </div>
                                                <div id="faq-1" class="collapse" role="tabpanel" aria-labelledby="faq-h1" data-parent="#accordion">
                                                    <div class="card-body">
                                                        When adding money to your Intellivoid Account, the balance is associated with your Intellivoid Account and not
                                                        just one service. this means if there are other services provided by Intellivoid where a purchase can be made
                                                        then you can use your Intellivoid Account's balance as a form as payment rather than a payment processor such
                                                        as PayPal.
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="card">
                                                <div class="card-header" role="tab" id="faq-h2">
                                                    <h5 class="mb-0">
                                                        <a data-toggle="collapse" href="#faq-2" aria-expanded="false" aria-controls="faq-2">
                                                            Can i trust that my balance won't just disappear or become unusable?
                                                        </a>
                                                    </h5>
                                                </div>
                                                <div id="faq-2" class="collapse" role="tabpanel" aria-labelledby="faq-h2" data-parent="#accordion">
                                                    <div class="card-body">
                                                        Your balance will always be usable with any Intellivoid Service that offers some sort of way to purchase
                                                        either a service or a subscription. Your balance will not disappear, if it has due to some error (very unlikely)
                                                        you can expect Intellivoid Support to assist you with the problem and recover any loss
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="card">
                                                <div class="card-header" role="tab" id="faq-h3">
                                                    <h5 class="mb-0">
                                                        <a data-toggle="collapse" href="#faq-3" aria-expanded="false" aria-controls="faq-3">
                                                            I have enough money in my balance but cannot complete the purchase!
                                                        </a>
                                                    </h5>
                                                </div>
                                                <div id="faq-3" class="collapse" role="tabpanel" aria-labelledby="faq-h3" data-parent="#accordion">
                                                    <div class="card-body">
                                                        Your account may be limited, this is like suspension but it doesn't prevent you from using your
                                                        Intellivoid Account. This limitation will not be lifted until you contact Intellivoid Support to
                                                        resolve the issue. So be in mind that the limitation is not permanent but it will not be lifted
                                                        until you contact support.
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="card">
                                                <div class="card-header" role="tab" id="faq-h4">
                                                    <h5 class="mb-0">
                                                        <a data-toggle="collapse" href="#faq-4" aria-expanded="false" aria-controls="faq-4">
                                                            Can i withdraw money from my Intellivoid Account?
                                                        </a>
                                                    </h5>
                                                </div>
                                                <div id="faq-4" class="collapse" role="tabpanel" aria-labelledby="faq-h4" data-parent="#accordion">
                                                    <div class="card-body">
                                                        If you are affiliated and the money added to your balance is from affiliations, yes but you
                                                        need to contact Intellivoid Support to request a payout. otherwise no, this system is not meant
                                                        to act like PayPal, opening a dispute with the Payment processor will result in suspension in
                                                        your account.
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="card">
                                                <div class="card-header" role="tab" id="faq-h5">
                                                    <h5 class="mb-0">
                                                        <a data-toggle="collapse" href="#faq-5" aria-expanded="false" aria-controls="faq-5">
                                                            I got suspended! Can i get a refund?
                                                        </a>
                                                    </h5>
                                                </div>
                                                <div id="faq-5" class="collapse" role="tabpanel" aria-labelledby="faq-h5" data-parent="#accordion">
                                                    <div class="card-body">
                                                        If you got suspended, you got suspended for a reason. It is very unlikely that you will get
                                                        suspended for no reason or simply because you made too many requests. We suspend accounts if
                                                        we think they are intended for spam (No balance, no subscriptions, used only once, etc.). or
                                                        other reasons that we consider appropriate such as opening a dispute with the payment processor
                                                        as a way to get away with freebies, If  you do violate the usage of Intellivoid services you
                                                        will simply become limited. In that case  you would need to contact support to lift the
                                                        limitation. During this limitation your balance  is untouched but nor is it usable until
                                                        the limitation has been lifted.
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="card">
                                                <div class="card-header" role="tab" id="faq-h6">
                                                    <h5 class="mb-0">
                                                        <a data-toggle="collapse" href="#faq-6" aria-expanded="false" aria-controls="faq-6">
                                                            I want a refund from purchasing a service/subscription
                                                        </a>
                                                    </h5>
                                                </div>
                                                <div id="faq-6" class="collapse" role="tabpanel" aria-labelledby="faq-6" data-parent="#accordion">
                                                    <div class="card-body">
                                                        We are happy to assist you if you want a refund from making a purchase or a subscription.
                                                        You can either be refunded by having the amount you paid for restored back to your Intellivoid
                                                        Account or via the payment processor you used to add the amount to your Intellivoid Account.
                                                        But you need to contact Intellivoid Support first so we can come up with a option that works
                                                        best for you.
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="card">
                                                <div class="card-header" role="tab" id="faq-h7">
                                                    <h5 class="mb-0">
                                                        <a class="text-danger" data-toggle="collapse" href="#faq-7" aria-expanded="false" aria-controls="faq-7">
                                                            I already paid but my balance doesn't update!
                                                        </a>
                                                    </h5>
                                                </div>
                                                <div id="faq-7" class="collapse" role="tabpanel" aria-labelledby="faq-7" data-parent="#accordion">
                                                    <div class="card-body">
                                                        All transactions are reviewed manually, this can take up to 8 hours maximum but usually 1 hour or so.
                                                        If for some reason something goes wrong, you will be refunded and we will send you an email that's
                                                        associated with your PayPal account or alternatively your Intellivoid Account explaining the details.
                                                        If for some reason it takes more than 8 hours please contact Intellivoid Support for assistance,
                                                        <b class="text-danger">do not open a dispute unless it takes more than 12 hours otherwise your account will be suspended</b>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>

                                        <hr/>

                                        <h4><?PHP HTML::print(TEXT_ADD_BALANCE_HEADER); ?></h4>
                                        <p><?PHP HTML::print(str_ireplace('%s', 'intellivoid.dev@gmail.com', TEXT_ADD_BALANCE_DESC)); ?></p>

                                        <div class="dropdown">
                                            <button class="btn btn-primary btn-outline-secondary dropdown-toggle" type="button" id="dropdownMenuOutlineButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="mdi mdi-paypal"></i>Add to balance with PayPal </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuOutlineButton2">
                                                <a class="dropdown-item" href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=FLLNCMMRHFT4E" target="_blank">US $5.00</a>
                                                <a class="dropdown-item" href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=NN3U3ZKFN9NSG" target="_blank">US $10.00</a>
                                                <a class="dropdown-item" href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=GC4AXGEBKH4HY" target="_blank">US $20.00</a>
                                                <a class="dropdown-item" href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=7C7KBDN8QUAR2" target="_blank">US $30.00</a>
                                                <a class="dropdown-item" href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=FZJGN4HRS4D6E" target="_blank">US $40.00</a>
                                                <a class="dropdown-item" href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=YLUR4PWD88FJ8" target="_blank">US $50.00</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <?PHP HTML::importSection('footer'); ?>
        </div>

        <?PHP HTML::importSection('js_scripts'); ?>

    </body>
</html>
