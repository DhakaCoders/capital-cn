const admin = require('./admin.prod')();
const front = require('./frontend.prod')();
process.noDeprecation = true;
module.exports = [admin, front];
