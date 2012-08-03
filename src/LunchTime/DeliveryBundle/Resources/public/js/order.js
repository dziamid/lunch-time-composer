
LT.Order = function (data) {
    var self = this;

    self.id = ko.observable();
    self.clientId = ko.observable();
    self.date = ko.observable();
    self.items = ko.observableArray([]);

    self.title = ko.deferredComputed(function () {
        return self.date().toString('MMMM d');
    });

    self.activeItems = ko.deferredComputed(function () {
        return ko.utils.arrayFilter(self.items(), function (item) {
            return item.isActive();
        });

    });

    self.activeCategories = ko.deferredComputed(function () {
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

    self.totalPrice = ko.deferredComputed(function () {
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

    self.initialize = function (data) {
        data = data || {};

        self.id(data.id || null);
        self.clientId(data.client_id || LT.OrderRepository.generateClientId());
        self.date(Date.parseExact(data.date, 'yyyy-MM-dd HH:mm:ss'));
        data.items = data.items || [];
        for (var i = 0; i < data.items.length; i++) {
            self.items.pushUnique(LT.OrderItemRepository.create(data.items[i]));
        }
    };

    self.update = self.initialize;

    self.initialize(data);

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

    self.objects = ko.observableArray([]);
    self.create = function (data) {
        var object = ko.utils.arrayFirst(self.objects(), function (o) {
            return ko.utils.unwrapObservable(o.id) == data.id;
        });
        if (!object) {
            object = new LT.Order(data);
            self.objects.push(object);
        }

        return object;
    };


    self.update = function (data) {
        var object = ko.utils.arrayFirst(self.objects(), function (o) {
            return ko.utils.unwrapObservable(o.clientId) == data.client_id;
        });
        //do we need to created orders if not found in repository?
        if (!object) {
            return;
        }

        object.update(data);

        return object;
    };
});