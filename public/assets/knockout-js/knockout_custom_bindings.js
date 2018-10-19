ko.bindingHandlers.masked = 
{
    init: function (element, valueAccessor, allBindingsAccessor) 
    {
        var mask = allBindingsAccessor().mask || {};
        var placeholder = allBindingsAccessor().placeholder;
        if (placeholder) 
        {
            $(element).mask(mask, { placeholder: placeholder });
        } 
        else 
        {
            $(element).mask(mask);
        }
        ko.utils.registerEventHandler(element, "change", function () 
        {
            var observable = valueAccessor();
            observable($(element).val());
        });
    },
    update: function (element, valueAccessor) {
        var value = ko.utils.unwrapObservable(valueAccessor());
        $(element).val(value);
    }
};