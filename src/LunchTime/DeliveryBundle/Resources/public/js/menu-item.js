
LT.MenuItem = function (data) {
    var self = this;
    data = data || {};
    //id is required
    self.id = ko.observable(data.id);
    //title is required
    self.title = ko.observable(data.title);
    //price is required
    self.price = ko.observable(parseFloat(data.price));

    self.category = ko.observable(LT.MenuCategoryRepository.find(data.category.id));

    self.toJSON = function () {
        var obj = ko.toJS(this);

        return {
            id: obj.id
        };
    };
};

/**
 * Factory of LT.MenuItem entities
 *
 */
LT.MenuItemRepository = new (function () {
    var self = this;
    self.objects = ko.observableArray([]);
    self.create = function (data) {
        var object = ko.utils.arrayFirst(self.objects(), function (o) {
            return ko.utils.unwrapObservable(o.id) == data.id;
        });
        if (!object) {
            object = new LT.MenuItem(data);
        }
        self.objects.push(object);
        return object;
    }
});


