var LT = typeof window.LT !== 'undefined' ? window.LT : {};

LT.Menu = function (data) {
    var self = this;

    self.id = ko.observable();
    self.date = ko.observable();
    self.items = ko.observableArray([]);

    //categories are populates from items that menu has
    self.categories = ko.deferredComputed(function () {
        var cats = ko.utils.arrayMap(self.items(), function (item) {
            return item.category();
        });

        return ko.utils.arrayGetDistinctValues(cats);
    });

    self.getItemsForCategory = function (cat) {
        return ko.utils.arrayFilter(self.items(), function (item) {
            return item.category() === cat;
        });
    };

    self.title = ko.deferredComputed(function () {
        return self.date().toString('MMMM d');
    });


    self.initialize = function (data) {
        data = data || {};

        self.id(data.id || null);
        self.date(Date.parseExact(data.date, 'yyyy-MM-dd HH:mm:ss'));

        data.items = data.items || [];
        for (var i = 0; i < data.items.length; i++) {
            // add all categories that this menu has to common repository
            LT.MenuCategoryRepository.create(data.items[i].category);
            self.items.push(LT.MenuItemRepository.create(data.items[i]));
        }
    };

    self.update = self.initialize;

    self.initialize(data);
};