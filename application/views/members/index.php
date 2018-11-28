<div class="ui container">
    <div class="ui vertical segment">
      <div class="ui hidden divider"></div>
      <h2 class="ui header">
        <i class="users icon"></i>
        <div class="content" style="width:100%">
          Members
          <div class="sub header">
            Manage Member Information
            <div class="ui labels" style="float:right">
              <div id="member-count" class="ui label" title="number of members">
                <i class="users icon"></i>
                <span>24</span>
              </div> <!-- ui label -->
            </div> <!-- ui lables -->
          </div> <!-- sub header -->
        </div> <!-- content -->
      </h2> <!-- ui header -->
    </div> <!-- ui vertical segment -->
    <div id="mainmenu" class="ui pointing menu">
      <a data-target="list" class="active item"><i class="list icon"></i>Members List</a>
      <a data-target="add" class="green item"><i class="plus icon"></i> Add Member</a>
      <div class="right menu">
        <div class="item">
          <div class="ui transparent icon input">
            <input id="search" type="text" placeholder="Search Member...">
            <i class="search link icon"></i>
          </div> <!-- ui transparent icon input -->
        </div> <!-- item -->
      </div> <!-- right menu -->
    </div> <!-- ui pointing menu -->
    <div class="panels">

      <!-- Panel for List of Members -->
      <div id="list" class="ui segment activated panel">
        <div id="no-results" class="deactivated ui placeholder segment">
          <div class="ui icon header">
            <i class="search icon"></i>
            <span></span>
          </div>
        </div>
        <div id="card-list" class="ui three stackable link cards">
        </div>
      </div>

      <!-- Panel for Add Member form -->
      <div id="add" class="ui segment panel">
        <?php echo form_open('members/add', array('class' => 'ui form')); ?>
          <h3 class="ui dividing header">
            Add a New Member
          </h3>
          <div class="field">
            <label>Name</label>
            <div class="two fields">
              <div class="field">
                <input type="text" name="firstname" id="firstname" placeholder="First Name">
              </div>
              <div class="field">
                <input type="text" name="lastname" id="lastname" placeholder="Last Name">
              </div>
            </div>
          <div class="field">
            <label>Address</label>
            <div class="two fields">
              <div class="field">
                <input type="text" name="address1" id="address1" placeholder="Address Line 1">
              </div>
              <div class="field">
                <input type="text" name="address2" id="address2" placeholder="Address Line 2">
              </div>
              <div class="field">
                <input type="text" name="address3" id="address3" placeholder="Address Line 3">
              </div>
            </div>
          <div class="field">
            <label>Contact Details</label>
            <div class="two fields">
              <div class="field">
                <input type="text" name="email" id="email" placeholder="Email address">
              </div>
              <div class="field">
                <input type="text" name="mobile" id="mobile" placeholder="Mobile No">
              </div>
            </div>
          </div>
          <button type="submit" class="ui black button">Submit</button>
        </form>
      </div>
    </div>

    <!-- member retirement confirmation model (hidden) -->
    <div id="retirement" class="ui basic mini modal">
      <div class="ui icon header">
        <i class="user times icon"></i>
        Retire <span id="name"></span>
      </div>
      <div class="centered content">
        <p>Are you sure? This action cannot be revoked later.</p>
      </div>
      <div class="actions">
        <div class="ui red basic cancel inverted button">
          <i class="remove icon"></i>
          No
        </div>
        <div class="ui green ok inverted button">
          <i class="checkmark icon"></i>
          Yes
        </div>
      </div>
    </div>
  </div> <!-- ui container -->

<script>
  function render_cards (users) {
    var cards = [];
    if (users) users.forEach(user => {
      var card = $('<div class="card"></div>');

      // card image definition
      var card_image = $('<div class="image"></div>');
      var card_image_img = $('<img/>');

      card_image_img.attr({
        'src': user.image,
        'alt': user.fullname
      });

      card_image.append(
        card_image_img
      );

      // card content
      var card_content = $('<div class="content"></div>');
      var card_content_header = $('<div class="header"></div>')
      var card_content_meta = $('<div class="meta"></div>');
      var card_content_description = $('<div class="description"></div>');

      card_content_header.text(user.fullname);
      card_content_meta.text('joined on ' + user.joinedOn);
      card_content_description.text(user.details);

      card_content.append(
        card_content_header,
        card_content_meta,
        card_content_description
      );

      // card buttons
      var card_buttons = $('<div class="ui bottom attached buttons"></div>');
      var card_buttons_retire = $('<div class="ui negative button retire">Retire</div>');
      var card_buttons_payment = $('<div class="ui button payment">Payments</div>');

      card_buttons_retire.attr({
        'data-tag': user.fullname
      });
      card_buttons_payment.attr({
        'data-tag': user.id
      });

      card_buttons.append(
        card_buttons_retire,
        card_buttons_payment
      );

      card.append(
        card_image,
        card_content,
        card_buttons
      );

      cards.push(card);
    });

    $('div#card-list').empty();
    if (cards.length <= 0) {
      $('div#no-results').removeClass('deactivated');
      $('div#card-list').addClass('deactivated');
      $('div#no-results span').text('No members found')
    } else {
      $('div#no-results').addClass('deactivated');
      $('div#card-list').removeClass('deactivated');
      cards.forEach(card => {
        $('div#card-list').append(card);
      })
    }
  }

  $(document).ready(function () {
    $('.ui.form').form({
      fields: {
        firstname: 'empty',
        lastname: 'empty',
        address1: 'empty',
        address2: 'empty',
        mobile: 'empty'
      }
    });
    // main menu transitions
    var items = $('#mainmenu a.item');
    items.click(function() {
      items.removeClass('active');
      $(this).addClass('active');
      var relatedPanel = $(this).data('target');
      if (relatedPanel === undefined) { return; }
      $('div.activated.panel').transition('slide left').removeClass('activated');
      $('div.panel#'+relatedPanel).transition('slide right').addClass('activated');
    })

    // display user list
    // user {
    //   id
    //   fullname
    //   joinedOn
    //   details
    //   image
    // }
    if (result.data && result.data.users) {
      render_cards(result.data.users);
    } else {
      render_cards(undefined);
    }

    // user retiring confirmation
    $('.button.retire').click(function() {
      $('.ui.basic.modal#retirement > .header > #name').text($(this).data('tag'));
      $('.ui.basic.modal#retirement')
        .modal({
          onDeny: function() { console.log('denied'); },
          onApprove: function() { console.log('approved'); }
        })
        .modal('show');
    });

    // search functionality
    $('input#search').on('keyup', function () {
      var search_key = $(this).val();
      var filtered = result.data.users;
      if (search_key.length > 0) {
        filtered = result.data.users.filter(user => {
          return user.fullname.toLowerCase().indexOf(search_key.toLowerCase()) >= 0;
        })
      }
      render_cards(filtered);
    })

    $('#member-count > span').text(result.data.users.length);
  });
</script>