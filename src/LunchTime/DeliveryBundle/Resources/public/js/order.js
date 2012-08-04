
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
            item = LT.OrderItemRepository.create({menuItem: menuItem, amount: 1});
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
        //we need to created or update really, depending on whether client_id is null or not
        for (var i = 0; i < data.items.length; i++) {
            var item = LT.OrderItemRepository.createOrUpdate(data.items[i]);
            item && self.items.pushUnique(item);
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

    self.objects = ko.observableArray([]);

    self.lastId = 1;

    self.generateClientId = function () {
        self.lastId++;
        return self.lastId;
    };

    /**
     * Find object by propertyName that matches propertyValue
     *
     */
    self.find = function (propertyName, propertyValue) {
        return ko.utils.arrayFirst(self.objects(), function (o) {
            return ko.utils.unwrapObservable(o[propertyName]) == propertyValue;
        });
    };

    /**
     * Creates a new entity and adds it to repository
     *
     * @param data
     * @return LT.Order
     */
    self.create = function (data) {
        var object, id;

        if (!(id = data.client_id) || !(object = self.find('id', id))) {
            object = new LT.Order(data);
            self.objects.push(object);
        }

        return object;
    };

    /**
     * Creates or updates item with data depending on client_id property
     *
     * If client_id propery is valid, then entity is already in repository and needs to be updades,
     * otherwise - entity is not yet in repository - so create it
     *
     * @param data array
     */
    self.createOrUpdate = function (data) {
        var object, clientId;

        if ((clientId = data.client_id) && (object = self.find('clientId', clientId))) {
            //entity exists
            return object.update(data);
        } else {
            return self.create(data);
        }
    };


});