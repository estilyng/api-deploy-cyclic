export default {
    methods: {
        checkTypeNotify(notify) {
            let configNotify = {};

            if (notify.data.type == "response") {
                configNotify.color = "teal";
                configNotify.icon = "mdi-message-text-outline";
                configNotify.name = "Mensagem";
                configNotify.text = this.abbreviate(notify.data.text);
                return configNotify;
            }
            if (notify.data.type == "call") {
                configNotify.color = "primary";
                configNotify.icon = "mdi-face-agent";
                configNotify.name = "Nome";
                configNotify.text = notify.data.call_name;
                return configNotify;
            }
        },

        abbreviate(str) {
            const name = str.replace(/\s+/gi, " ").trim();
            const array_names = name.split(" ");

            if (array_names.length > 1) {
                const text = array_names
                    .map((work, i) => {
                        if (i == 0) {
                            return work + " ...";
                        }
                    })
                    .join(" ");
                return text;
            } else return name
        },
    }
}