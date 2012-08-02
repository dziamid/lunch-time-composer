var LT = typeof window.LT !== 'undefined' ? window.LT : {};

LT.Menu = function (data) {
    var self = this;
    data = data || {};
    data.items = data.items || [];

    //id is required
    self.id = ko.observable(data.id);
    //date is required
    self.date = ko.observable(Date.parseExact(data.date, 'yyyy-MM-dd HH:mm:ss'));

    // add all categories that this menu has to common repository
    for (var i = 0; i < data.items.length; i++) {
        var cat = LT.MenuCategoryRepository.create(data.items[i].category);
    }

    self.items = ko.observableArray([]);
    for (var i = 0; i < data.items.length; i++) {
        self.items.push(LT.MenuItemRepository.create(data.items[i]));
    }

    //categories are populates from items that menu has
    self.categories = ko.computed(function () {
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


    self.title = ko.computed(function () {
        return self.date().toString('MMMM d');
    });
};