@extends($layout)
@section('scripts')

{{--  How to?  --}}

{{--  <script>
$('#return-link').click(function(e) {
    $('/frequently-asked-questions/#collapse6').collapse('show');        
});
</script>  --}}


@endsection
@section('header')
@endsection


@section('content')

<div class="container">
<h1 style="margin-bottom: 25px; text-align: center;">Frequently Asked Questions</h1>
{{-- Shop & Custom Orders   --}}
<h3 style="margin-bottom: 25px;">Custom Orders</h3>

  <div class="panel-group" id="accordion">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h4 data-toggle="collapse" data-parent="#accordion" href="#collapse1" class="panel-title expand">
           <div class="right-arrow pull-right">+</div>
          <a href="#">How do I begin the custom process?</a>
        </h4>
      </div>
      <div id="collapse1" class="panel-collapse collapse">
        <div class="panel-body">
      Create a one-of-a-kind ceremonial ring or future heirloom with the help of our Fine Jewelry experts. Our custom approach is tailored to you, and grounded in your unique love story. Begin the experience with a private consultation with us, and learn about our original creative process—from design inspiration and diamond education to metal selection and stone sourcing. We know that this process may be unfamiliar to many of our customers, and are committed to providing the highest levels of service, consideration and care. Custom commissions are by appointment only; please call (682)472-3039 to make your appointment today.
        </div>
      </div>
    </div>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h4 data-toggle="collapse" data-parent="#accordion" href="#collapse2" class="panel-title expand">
            <div class="right-arrow pull-right">+</div>
          <a href="#">Do you work with clients remotely?</a>
        </h4>
      </div>
      <div id="collapse2" class="panel-collapse collapse">
        <div class="panel-body">
        We’re happy to work remotely, and take pride in serving people all over the world with both bespoke and custom orders. <a href="mailto:info@freyasfinejewelry.com">E-mail</a> or call us at (682)472-3039 to arrange a consultation via phone.
        Please allow 2-5 days for us to respond as custom queries require extra time and attention.
        </div>
      </div>
    </div>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h4 data-toggle="collapse" data-parent="#accordion" href="#collapse3" class="panel-title expand">
            <div class="right-arrow pull-right">+</div>
          <a href="#">How quickly can my jewelry get made? Do you provide rush service?</a>
        </h4>
      </div>
      <div id="collapse3" class="panel-collapse collapse">
        <div class="panel-body">Our bespoke and custom pieces can usually be made to order in 4–6 weeks from the date the order is finalized. We provide rush services whenever possible, though fees may apply.</div>
      </div>
    </div>
  </div> 
<hr>
{{-- Shipping & Returns   --}}
<h3 style="margin-bottom: 25px;">Shipping & Returns</h3>

  <div class="panel-group" id="accordion">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h4 data-toggle="collapse" data-parent="#accordion" href="#collapse4" class="panel-title expand">
           <div class="right-arrow pull-right">+</div>
          <a href="#">What is your shipping method?</a>
        </h4>
      </div>
      <div id="collapse4" class="panel-collapse collapse">
        <div class="panel-body">
      We ship all of our jewelry via UPS Next Day Delivery. All of our pieces are fully insured while in transit, and must be signed for when received.
      </div>
      </div>
    </div>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h4 data-toggle="collapse" data-parent="#accordion" href="#collapse5" class="panel-title expand">
            <div class="right-arrow pull-right">+</div>
          <a href="#">Do you ship internationally?</a>
        </h4>
      </div>
      <div id="collapse5" class="panel-collapse collapse">
        <div class="panel-body">
        We serve customers around the world via FedEx International Priority. Shipping times vary, depending on the destination country, and take approximately 3–15 business days. All pieces are fully insured during transit time and are subject to all duties and taxes imposed by the destination country.
        </div>
      </div>
    </div>
    <div class="panel panel-default" id="returnpolicy">
      <div class="panel-heading">
        <h4 data-toggle="collapse" data-parent="#accordion" href="#collapse6" class="panel-title expand">
            <div class="right-arrow pull-right">+</div>
          <a href="#">What is your return policy?</a>
        </h4>
      </div>
      <div id="collapse6" class="panel-collapse collapse">
        <div class="panel-body">
            All Special Order, Custom and Bespoke pieces are Final Sale, and not eligible for returns or refunds.
             We gladly accept returns on all other items within two weeks of order delivery for a full refund or exchange. All merchandise must be returned in its original packaging and in its original condition.
        </div>
    </div>
      <div class="panel panel-default">
      <div class="panel-heading">
        <h4 data-toggle="collapse" data-parent="#accordion" href="#collapse7" class="panel-title expand">
            <div class="right-arrow pull-right">+</div>
          <a href="#">How do I return an online purchase?</a>
        </h4>
      </div>
    <div id="collapse7" class="panel-collapse collapse">
        <div class="panel-body">
        To return an online purchase, please contact <a href="mailto:info@freyasfinejewelry.com">info@freyasfinejewelry.com</a> for a return authorization form. In the subject line, please include RETURN, your name, and the order number. You are responsible for insuring your own return, unless otherwise arranged through an associate. You are also welcome to return eligible items in person.

        If you are have any questions about your return or our return policy, please email us at <a href="mailto:info@freyasfinejewelry.com">info@freyasfinejewelry.com</a>.
        </div>
    </div>
  </div> 
<hr>
{{-- Appraisals, Insurance, Warranties   --}}
<h3 style="margin-bottom: 25px;">Appraisal, Insurance, & Warranties</h3>

  <div class="panel-group" id="accordion">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h4 data-toggle="collapse" data-parent="#accordion" href="#collapse8" class="panel-title expand">
           <div class="right-arrow pull-right">+</div>
          <a href="#">Can I get an appraisal or evaluation report?</a>
        </h4>
      </div>
      <div id="collapse8" class="panel-collapse collapse">
        <div class="panel-body">
     We are happy to provide you with an evaluation report once your purchase is complete. Evaluation reports document the retail value of each piece for insurance purposes. Please note, however, that an evaluation report is not an appraisal. A formal appraisal requires an independent assessment by a certified appraiser, and is unfortunately not a service that we can offer.
      </div>
      </div>
    </div>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h4 data-toggle="collapse" data-parent="#accordion" href="#collapse9" class="panel-title expand">
            <div class="right-arrow pull-right">+</div>
          <a href="#">Do you provide insurance?</a>
        </h4>
      </div>
      <div id="collapse9" class="panel-collapse collapse">
        <div class="panel-body">
        We always recommend that you insure your jewelry, but we do not offer insurance through Freya's Fine Jewelry.
        </div>
      </div>
    </div>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h4 data-toggle="collapse" data-parent="#accordion" href="#collapse10" class="panel-title expand">
            <div class="right-arrow pull-right">+</div>
          <a href="#">Do you provide warranties?</a>
        </h4>
      </div>
      <div id="collapse10" class="panel-collapse collapse">
        <div class="panel-body">
        We provide a one-year warranty on all of our jewelry from the date of completion. If any issues arise in the first year, we will repair your piece free of charge. It is your responsibility to ship and insure your jewelry. We will return your piece insured once repaired.

        In or out of warranty, we are always happy to repair damaged pieces. Fees for this service vary according to the extent of repair.   
        </div>
    </div>
  </div> 
<hr>

</div>



@endsection

@section('modals')
@endsection