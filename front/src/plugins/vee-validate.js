import { extend } from 'vee-validate'
import { required, email, confirmed, min } from 'vee-validate/dist/rules'

extend("required", {
    ...required,
    message: "Campo Obrigatório"
});
extend("email", {
    ...email,
    message: "Ex: nome@domínio.com"
});
extend("confirmed", {
    ...confirmed,
    message: "Valor inválido"
});
extend("min", {
    ...min,
    message: "mínimo 8 caracters"
});