module.exports = (app, con) => {

  app.listen(app.get("port"), () => {

    console.log(`API PicPay - porta ${app.get("port")}`);

  });
}