<section class="dark-grey-text mb-5 wow fadeIn" style="margin-top: 5%;" id="message">
	
	<div class="col-12">
        <h4 class="text-center font-weight-bold dark-grey-text mb-2">
            <strong>Nevíte si rady? Napište nám a my Vám s radostí pomůžeme.</strong>
        </h4>
        <hr class="primary-color mb-5">
    </div>

    <?php
      if (isset($_GET['error_message']) && $_GET['error_message'] == 'wrong_input') { ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert" style="margin-bottom: 40px;">
          <strong>Zadali jste neplatné údaje.</strong> Zadejte platné údaje.
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div> <?php
      } elseif (isset($_GET['error_message'])) { ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert" style="margin-bottom: 40px;">
          <strong>Něco se pokazilo.</strong> Prosíme, kontaktujte nás na naší e-mailovou adresu.
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div> <?php
      } elseif (isset($_GET['success_message'])) { ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert" style="margin-bottom: 40px;">
          <strong>Váše zpráva byla odeslána, děkujeme.</strong> Pokusíme se ji vyřešit v co nejkratším intervale.
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div> <?php
      }
      ?>

	<form method="POST" action="">
	    <div class="row d-flex justify-content-center">
	        <div class="col-lg-5 mb-lg-0 pb-lg-3 mb-4">
				<div class="card">
					<div class="card-body">
						<div class="form-header primary-color" style="box-shadow: 0 5px 11px 0 rgba(0,0,0,.18), 0 4px 15px 0 rgba(0,0,0,.15);border-radius: 2px;margin: 0 10% 0 10%;">
							<h4 style="text-align: center;padding: 20px;margin-top: -3.13rem;">
								<label style="color: white;"><i class="fas fa-envelope"></i> Kontaktní formulář</label>
							</h4>
						</div>
					<div class="md-form">
						<input name="contactForm_name" type="text" id="form-name" class="form-control">
						<label for="form-name">Vaše jméno</label>
					</div>
					<div class="md-form">
					    <input name="contactForm_email" type="text" id="form-email" class="form-control">
					    <label for="form-email">Váš e-mail</label>
					</div>
					<div class="md-form">
					    <input name="contactForm_subject" type="text" id="form-Subject" class="form-control">
					    <label for="form-Subject">Předmět zprávy</label>
					</div>
					<div class="md-form">
					    <textarea name="contactForm_message" id="form-text" class="form-control md-textarea" rows="3"></textarea>
					    <label for="form-text">Text zprávy</label>
					</div>
					<div class="text-center">
					    <button type="submit" name="email_send_submit" class="btn btn-primary">Odeslat</button>
					</div>
					</div>
				</div>
	        </div>

	        <div class="col-lg-7">
	          	<div id="map-container-section" class="z-depth-1-half map-container-section mb-4" style="height: 400px">
	            	<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d41054.37896465077!2d15.167386087867433!3d49.97575852952259!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x470c6a8c397951d5%3A0x400af0f6614dd50!2zxIxlcnZlbsOpIFBlxI1reQ!5e0!3m2!1scs!2scz!4v1587551000166!5m2!1scs!2scz" frameborder="0" style="border:0;" allowfullscreen=""></iframe>
	          	</div>
	          	<div class="row text-center">
	            	<div class="col-md-4">
	              		<i style="position: relative;display: inline-block;width: 47px;height: 47px;font-size: 23px;background: #007bff;color: white;margin: 10px;padding-top: 12px;vertical-align: middle;border-radius: 50%;box-shadow: 0 5px 11px 0 rgba(0,0,0,.18), 0 4px 15px 0 rgba(0,0,0,.15);" class="fas fa-map-marker-alt"></i>
	              		<p>New York, 94126</p>
	              		<p class="mb-md-0">United States</p>
	            	</div>
	            	<div class="col-md-4">
	              		<i style="position: relative;display: inline-block;width: 47px;height: 47px;font-size: 23px;background: #007bff;color: white;margin: 10px;padding-top: 12px;vertical-align: middle;border-radius: 50%;box-shadow: 0 5px 11px 0 rgba(0,0,0,.18), 0 4px 15px 0 rgba(0,0,0,.15);" class="fas fa-phone"></i>
	              		<p>+ 01 234 567 89</p>
	              		<p class="mb-md-0">Mon - Fri, 8:00-22:00</p>
	            	</div>
	            	<div class="col-md-4">
	              		<i style="position: relative;display: inline-block;width: 47px;height: 47px;font-size: 23px;background: #007bff;color: white;margin: 10px;padding-top: 12px;vertical-align: middle;border-radius: 50%;box-shadow: 0 5px 11px 0 rgba(0,0,0,.18), 0 4px 15px 0 rgba(0,0,0,.15);" class="fas fa-envelope"></i>
	              		<p>info@gmail.com</p>
	              		<p class="mb-0">sale@gmail.com</p>
	            	</div>
	          	</div>
	        </div>
	    </div>	
	</form>
</section>
