LT.OrderItem = function (data) {
    var self = this;

    self.id = ko.observable();
    self.clientId = ko.observable();
    self.menuItem = ko.observable();
    self.amount = ko.observable();

    self.title = ko.deferredComputed(function () {
        return self.menuItem().title();
    });
    self.price = ko.deferredComputed(function () {
        return self.menuItem().price() * self.amount();
    });
    self.addOne = function () {
        return self.amount(self.amount() + 1);
    };
    self.removeOne = function () {
        return self.amount(self.amount() - 1);
    };

    self.isNew = ko.deferredComputed(function () {
        return self.id() === null;
    });

    self.isRemoved = ko.deferredComputed(function () {
        return self.amount() == 0;
    });

    self.isActive = ko.deferredComputed(function () {
        return self.amount() > 0;
    });

    self.toJSON = function () {
        var obj = ko.toJS(this);

        var data = {
            id: obj.id,
            client_id: obj.clientId,
            menu_item: obj.menuItem,
            amount: obj.amount
        };
        if (obj.isRemoved) {
            data._destroy = true;
        }

        return data;
    };

    self.initialize = function (data) {
        data = data || {};

        self.id(data.id || null);
        self.clientId(data.client_id || LT.OrderItemRepository.generateClientId());
        self.menuItem(data.menuItem || LT.MenuItemRepository.create(data.menu_item));
        self.amount(data.amount || 0);
    };

    self.update = self.initialize;
    self.initialize(data);

};

/**
 * Factory of LT.OrderItem entities
 *
 */
LT.OrderItemRepository = new (function () {
    var self = this;
    self.objects = ko.observableArray([]);

    /**
     * Find object by propertyName that matches propertyValue
     *
     */
    self.find = function (propertyName, propertyValue) {
        return ko.utils.arrayFirst(self.objects(), function (o) {
            return  ko.utils.unwrapObservable(o[propertyName]) == propertyValue;
        });
    };

    /**
     * Creates a new entity and adds it to repository
     *
     * @param data
     * @return LT.OrderItem
     */
    self.create = function (data) {
        var object;

        if (!data.id || !(object = self.find('id', data.id))) {
            object = new LT.OrderItem(data);
            self.objects.push(object);
        }

        return object;
    };

    self.lastId = 1;

    self.generateClientId = function () {
        self.lastId++;
        return self.lastId;
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
