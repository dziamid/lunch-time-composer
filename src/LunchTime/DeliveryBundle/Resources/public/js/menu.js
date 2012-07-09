var LT = typeof window.LT !== 'undefined' ? window.LT : {};

LT.Menu = function (data) {
    var self = this;
    data = data || {};
    data.items = data.items || [];

    //id is required
    self.id = ko.observable(data.id);
    //date is required
    self.date = ko.observable(Date.parse(data.date));

    //categories are populates from items that menu has
    self.categories = ko.observableArray([]);
    for (var i = 0; i < data.items.length; i++) {
        var cat = LT.MenuCategoryRepository.create(data.items[i].category);
            self.categories.pushUnique(cat);
    }

    self.items = ko.observableArray([]);
    for (var i = 0; i < data.items.length; i++) {
        self.items.push(LT.MenuItemRepository.create(data.items[i]));
    }
    self.title = ko.computed(function () {
        return self.date().toString('MMMM d');
    });
};