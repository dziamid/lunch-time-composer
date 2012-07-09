ko.observableArray['fn']['pushUnique'] = function (item) {
    var underlyingArray = this();
    if (ko.utils.arrayIndexOf(underlyingArray, item) === -1) {
        this.push(item);
    }
};