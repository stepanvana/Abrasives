<section id="subscribe" class="col-12 p-5 text-center wow fadeIn">
  <div class="row">
    <div class="col-md-6 mx-auto">
      <div class="card">
        <div class="card-body">
          <form class="text-center" style="color: #757575;" action="" action="" method="POST">
            <div class="col-12">
                <h4 class="text-center font-weight-bold dark-grey-text mb-2">
                    <strong>Odebírejte nás</strong>
                </h4>
            </div>
            <div class="md-form">
              <input type="email" name="email_sub" id="form1" class="form-control" required>
              <label for="form1">Vaše e-mailová adresa</label>
            </div>
            <div class="text-center">
              <button type="submit" name="email_sub_submit" class="btn btn-outline-primary btn-rounded my-4 waves-effect text-uppercase">Odebírat</button>
            </div>
          </form>
          <?php
          if (isset($_GET['error_subscribe']) && $_GET['error_subscribe'] == 'wrong_email') { ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert" style="margin-bottom: 40px;">
              <strong>Neplatný e-mail.</strong> Prosím zadejte existující e-mailovou adresu.
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div> <?php
          } elseif (isset($_GET['error_subscribe']) && $_GET['error_subscribe'] == 'existing_email') { ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert" style="margin-bottom: 40px;">
              <strong>Tento e-mail je již registrovaný.</strong>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div> <?php            
          } elseif (isset($_GET['error_subscribe'])) { ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert" style="margin-bottom: 40px;">
              <strong>Váš e-mail nebyl uložen.</strong> Něco se pokazilo, prosím informujte nás o tomto problému prostřednictvím e-mailu, děkujeme.
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div> <?php
          } elseif (isset($_GET['success_subscribe'])) { ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert" style="margin-bottom: 40px;">
              <strong>Váš e-mail byl uložen, děkujeme.</strong> Nyní od nás budete získávat pravidelné informace.
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div> <?php
          }
          ?>
        </div>
      </div>
    </div>
  </div>
</section>