jQuery(document).ready(function(){
    artfully.configure({
        base_uri: 'https://artfully-staging-pr-817.herokuapp.com/api/v3/',
        store_uri: 'https://artfully-staging-pr-817.herokuapp.com/widget/v3/'
    });
	artfully.widgets.cart()
  artfully.widgets.donation().display(artfully_donation.donationId);
  artfully.widgets.cart().display()
});