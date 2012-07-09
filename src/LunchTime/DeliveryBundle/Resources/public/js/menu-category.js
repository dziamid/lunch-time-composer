
LT.MenuCategory = function (data) {
    var self = this;
    data = data || {};
    //id is required
    self.id = ko.observable(data.id);
    //title is required
    self.title = ko.observable(data.title);

    self.items = ko.observableArray([]);
};

/**
 * Factory of LT.MenuCategory entities
 *
 */
LT.MenuCategoryRepository = new (function () {
    var self = this;
    self.objects = ko.observableArray([]);
    self.create = function (data) {
        var object = self.find(data.id);

        if (!object) {
            object = new LT.MenuCategory(data);
            self.objects.push(object);
        }
        return object;
    };

    /**
     * Find one object by id
     *
     * @param id
     * @return {*}
     */
    self.find = function (id) {
        return ko.utils.arrayFirst(self.objects(), function (o) {
            return ko.utils.unwrapObservable(o.id) == id;
        });
    };
});


