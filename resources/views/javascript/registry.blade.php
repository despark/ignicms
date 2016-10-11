@inject('registry', 'Despark\Cms\Javascript\Contracts\RegistryContract')
<script type="text/javascript">
    if (typeof Despark == 'undefined') {
        Despark = {};
    }
    Despark.js = Despark.js || {};
    Despark.js.registry = {
        'values': {!! json_encode($registry->getRegistry()) !!},
        'get': function (namespace, key) {
            if (typeof this.values[namespace] != 'undefined') {
                if (typeof key != 'undefined') {
                    if (typeof this.values[namespace][key] != 'undefined') {
                        return this.values[namespace][key]
                    }
                    var keys = key.split('.');
                    var found = this.values[namespace];
                    for (var i in keys) {
                        if (typeof found[keys[i]] != 'undefined') {
                            found = found[keys[i]];
                        } else {
                            return null;
                        }
                    }
                    return found;
                } else {
                    return this.values[namespace];
                }
            }
        }
    };
</script>