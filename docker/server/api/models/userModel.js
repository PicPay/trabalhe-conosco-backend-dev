var mongoose = require('mongoose');
var Schema = mongoose.Schema;

/**
 * Modelo de dados de um usuário do banco.
 * 
 * @author L.Gomes
 */
var UserSchema = new Schema({
    id: { type: String },
    name: { type: String },
    username: { type: String }
});

module.exports = mongoose.model('Users', UserSchema);