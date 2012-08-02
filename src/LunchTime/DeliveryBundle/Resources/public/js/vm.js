//this is to suppress undefined variable highlights
//need to refactor it to closure modules
var LT = typeof window.LT !== 'undefined' ? window.LT : {};
LT.config = typeof LT.config !== 'undefined' ? LT.config : {};

LT.viewModel = new (function (config) {
    var self = this;
    var i;
    self.menus = ko.observableArray([]);
    config.menus = config.menus || [];
    for (i = 0; i < config.menus.length; i++) {
        self.menus.push(new LT.Menu(config.menus[i]));
    }

    self.findMenu = function(menuId) {
        return ko.utils.arrayFirst(self.menus(), function (menu) {
            return ko.utils.unwrapObservable(menu.id) == menuId;
        });
    };

    self.orders = ko.observableArray([]);
    config.orders = config.orders || [];
    for (i = 0; i < config.orders.length; i++) {
        self.orders.push(new LT.Order(config.orders[i]));
    }

    self.activeMenu = ko.observable(null);
    self.activeMenu.subscribe(function (menu) {
        $.cookie('selected-menu-id', ko.utils.unwrapObservable(menu.id), { expires: 30*12 });
        //TODO: move activateMenu logic here
    });
    self.activeOrder = ko.observable(null);

    self.activateMenu = function (menu) {
        self.activeMenu(menu);
        var order = ko.utils.arrayFirst(self.orders(), function (order) {
            var orderDate = order.date();
            var menuDate = menu.date();
            return orderDate.equals(menuDate);
        });
        if (!order) {
            var menuDate = menu.date().toString('yyyy-MM-dd HH:mm:ss');
            order = new LT.Order({date: menuDate});
            self.orders.push(order);
        }
        self.activeOrder(order);
    };

    self.isActiveMenu = function (menu) {
        return menu === self.activeMenu();
    };

    /**
     * Adds a menu item to active order
     *
     * @param menuItem
     */
    self.addToActiveOrder = function (menuItem) {
        self.activeOrder().addItem(menuItem);
    };

    self.removeFromOrder = function (item) {
        self.activeOrder().removeItem(item);
    };

    self.submitOrders = function (data, event) {
        var btn = $(event.target);

        var ordersData = ko.toJSON(self.orders());
        console.log(ordersData);

        $.ajax({
            url: config.orderPersist,
            data: ordersData,
            type: 'POST',
            dataType: 'json',
            success: function (data) {
                if (data.success) {
                    var orders = new LT.Order(data.orders);

                    //self.activeOrder(order);
                }
            },
            beforeSend: function () { btn.button('loading')},
            complete: function () { btn.button('reset')}
        });
    };

    //initial data
    var menuId, menu;
    if ((menuId = $.cookie('selected-menu-id')) && (menu = self.findMenu(menuId))) {
        self.activateMenu(menu);
    } else {
        self.activateMenu(self.menus()[self.menus().length - 1]);
    }


})(LT.config);

ko.applyBindings(LT.viewModel);

