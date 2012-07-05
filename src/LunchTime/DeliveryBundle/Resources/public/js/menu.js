var LT = typeof window.LT !== 'undefined' ? window.LT : {};

LT.Menu = function (data) {
    var self = this;
    data = data || {};
    //id is required
    self.id = ko.observable(data.id);
    //date is required
    self.date = ko.observable(Date.parse(data.date));
    self.items = ko.observableArray([]);
    data.items = data.items || [];
    for (var i = 0; i < data.items.length; i++) {
        self.items.push(LT.MenuItemRepository.create(data.items[i]));
    }
    self.title = ko.computed(function () {
        return self.date().toString('MMMM d');
    });
};