module.exports = function (app, cors) {
    var userList = require('../controllers/userController');

    app.route('/users/:limit/:skip')
        .get(userList.list_users);

    app.route('/users/:limit/:skip/:filter')
        .get(userList.list_users_filtered);
}