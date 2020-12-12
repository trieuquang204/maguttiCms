
<shopping-cart
		:counter="{{StoreHelper::getCartItemCount()}}"
		cart_url="{{ url_locale('cart') }}"
		icon="fas fa-{{config('maguttiCms.store.cart.icon')}}"
		:cart-items="{{StoreHelper::getCartItems()}}"
		is-mobile="{{Agent::isDesktop()}}">
</shopping-cart>

