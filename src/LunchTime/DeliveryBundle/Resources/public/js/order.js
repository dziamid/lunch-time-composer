LT.Order = function (data) {
    var self = this;
    data = data || {};
    self.id = ko.observable(data.id || null);
    var clientId = data.client_id || LT.OrderRepository.generateClientId();
    self.clientId = ko.observable(clientId);
    //date is required
    self.date = ko.observable(Date.parseExact(data.date, 'yyyy-MM-dd HH:mm:ss'));

    self.title = ko.computed(function () {
        return self.date().toString('MMMM d');
    });

    self.items = ko.observableArray([]);
    data.items = data.items || [];
    for (var i = 0; i < data.items.length; i++) {
        self.items.push(new LT.OrderItem(data.items[i]));
    }

    self.activeItems = ko.computed(function () {
        return ko.utils.arrayFilter(self.items(), function (item) {
            return item.isActive();
        });

    });

    self.activeCategories = ko.computed(function () {
        var cats = ko.utils.arrayMap(self.activeItems(), function (item) {
            return item.menuItem().category();
        });

        return ko.utils.arrayGetDistinctValues(cats);
    });

    self.getActiveItemsForCategory = function (cat) {
        return ko.utils.arrayFilter(self.activeItems(), function (item) {
            return item.menuItem().category() === cat;
        });
    };

    self.totalPrice = ko.computed(function () {
        var total = 0;

        ko.utils.arrayForEach(self.items(), function (item) {
            total += item.price();
        });

        return total;
    });

    self.addItem = function (menuItem) {

        var item = ko.utils.arrayFirst(self.items(), function (item) {
            return menuItem == item.menuItem();
        });

        if (item) {
            item.addOne();
        } else {
            item = new LT.OrderItem({menuItem: menuItem, amount: 1});
            self.items.push(item);
        }
    };

    self.removeItem = function (item) {
        if (item.amount() > 1) {
            item.removeOne();
        } else {
            item.isNew() ? self.items.remove(item) : item.amount(0);

        }
    };

    self.toJSON = function () {
        var obj = ko.toJS(this);

        return {
            id: obj.id,
            client_id: obj.clientId,
            date: obj.date.toString('yyyy-MM-dd HH:mm:ss'),
            items: obj.items
        };
    };

};


/**
 * Factory of LT.Order entities
 *
 */
LT.OrderRepository = new (function () {
    var self = this;
    self.lastId = 1;

    self.generateClientId = function () {
        self.lastId++;
        return self.lastId;
    };
});