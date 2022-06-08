<?php
include 'header.php';
include 'nav.php';
?>

<div id="output"></div>  

<section style="height: 550px;position: relative;left: 0;z-index: 0;">
  <div style="background-color: rgba(0,0,0,.7);display: flex;-webkit-box-pack: center;justify-content: center;-webkit-box-align: center;align-items: center;height: 100%;">
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d41054.37896465077!2d15.167386087867433!3d49.97575852952259!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x470c6a8c397951d5%3A0x400af0f6614dd50!2zxIxlcnZlbsOpIFBlxI1reQ!5e0!3m2!1scs!2scz!4v1587551000166!5m2!1scs!2scz" frameborder="0" style="width: 100%;box-shadow: 0 5px 11px 0 rgba(0,0,0,.18), 0 4px 15px 0 rgba(0,0,0,.15);height: 100%;" allowfullscreen=""></iframe>
  </div>
</section>

<div id="contact_message" class="container">
  
  <section style="margin: 0 auto;position: relative;z-index: 0;padding-bottom: 4%;">
    <div style="box-shadow: 0 2px 5px 0 rgba(0,0,0,.16), 0 2px 10px 0 rgba(0,0,0,.12);border: 0;font-weight: 400;border-radius: 5px;background-color: white;width: 100%;margin-top: -7%;">
      <h1 class="wow fadeInUp" style="text-align: center;font-weight: 300!important;color:rgb(55, 58, 60);font-size:32px;padding: 4%;">
        Máte dotaz? Neváhejte a zeptejte se!
      </h1>

      <?php
      if (isset($_POST['email_send_submit'])) {
        $newMsgScs = $usersContrObj->createNewMessage($_POST['contactForm_name'], $_POST['contactForm_email'], $_POST['contactForm_subject'], $_POST['contactForm_message'], $_SERVER['REMOTE_ADDR']);
        if ($newMsgScs == true) { ?>
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Zpráva byla odeslána.</strong> Na Vaši zprávu odpovíme v co nejkratší době, děkujeme.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div> <?php
        } elseif ($newMsgScs == false) { ?>
          <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Zpráva nebyla odeslána.</strong> Něco se pokazilo, prosím kontaktujte nás prostřednictvím jiných mediálních zařízeních.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div> <?php
        }
      }
      ?>

      <section class="px-md-5 mx-md-5 text-center text-lg-left dark-grey-text" style="padding-bottom: 5%;">
        <div class="row wow fadeInUp" style="box-shadow: 0 5px 11px 0 rgba(0,0,0,.18), 0 4px 15px 0 rgba(0,0,0,.15);padding: 20px;">
          <div class="col-lg-7 col-md-12 mb-4 mb-md-0">
            <form action="" method="POST">
              <h3 style="margin: 5% 0 5% 0;text-align: center;">Kontaktní informace</h3>
              <div class="md-form md-outline mt-3">
                <input name="contactForm_name" type="text" id="form-email" class="form-control">
                <label for="form-email">Jméno</label>
              </div>
              <div class="md-form md-outline mt-3">
                <input name="contactForm_email" type="email" id="form-email" class="form-control">
                <label for="form-email">E-mail</label>
              </div>
              <div class="md-form md-outline">
                <input name="contactForm_subject" type="text" id="form-subject" class="form-control">
                <label for="form-subject">Předmět</label>
              </div>
              <div class="md-form md-outline mb-3">
                <textarea name="contactForm_message" id="form-message" class="md-textarea form-control" rows="3"></textarea>
                <label for="form-message">Váš dotaz</label>
              </div>
              <div class="text-center">
                <button name="email_send_submit" type="submit" class="btn btn-outline-primary waves-effect btn-md ml-0">Zeptat se<i class="far fa-paper-plane ml-2"></i></button>
              </div>
            </form>
          </div>

          <div class="col-lg-5 col-md-12 mb-4 mb-md-0" style="padding-left: 5%;padding-top: 1%;">
            <h3 style="margin: 5% 0 10% 0;text-align: center;">Kontaktní informace</h3>
            <ul style="text-align: left!important;margin-left: -10%;">
              <li style="list-style-type: none;"><p style="font-size: 16px;font-weight: 300;margin-bottom: 10%;"><i class="fas fa-map-marker-alt" style="padding-right: 20px!important;"></i>New York, 94126, USA</p></li>
              <li style="list-style-type: none;"><p style="font-size: 16px;font-weight: 300;margin-bottom: 10%;"><i class="fas fa-phone" style="padding-right: 20px!important;"></i>+ 01 234 567 89</p></li>
              <li style="list-style-type: none;"><p style="font-size: 16px;font-weight: 300;margin-bottom: 10%;"><i class="far fa-envelope" style="padding-right: 20px!important;"></i>contact@example.com</p></li>
            </ul><hr>
            <div class="text-center">
              <button type="button" class="btn btn-fb" style="background-color: #3b5998;color: white;"><i class="fab fa-facebook-f pr-1"></i> Facebook</button>
              <button type="button" class="btn btn-tw" style="background-color: #55acee;color: white;"><i class="fab fa-twitter pr-1"></i> Twitter</button>
            </div>
          </div>
        </div>
      </section>
    </div>
  </section>

</div>   

<?php include 'footer.php'; ?>