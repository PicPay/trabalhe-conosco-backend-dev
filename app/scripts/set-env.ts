import { writeFile } from 'fs';
import { argv } from 'yargs';

// This is good for local dev environments, when it's better to
// store a projects environment variables in a .gitignore'd file
require('dotenv').config();

// Would be passed to script like this:
// `ts-node set-env.ts --environment=dev`
// we get it from yargs's argv object
const environment = argv.environment;
const isProd = environment === 'prod';

const targetPath = `./src/environments/environment.ts`;
const envConfigFile = `
export const environment = {
  production: ${isProd},
  api: "${isProd ? process.env.API_HTTP_CLIENT_BASE_URI : ''}"
};
`
writeFile(targetPath, envConfigFile, function (err) {
    if (err) {
        console.log(err);
    }
    console.log(`Output generated at ${targetPath}`);
});

if (!isProd) {
    const proxyPath = `./proxy.conf.json`;
    const proxyConfigFile = `
    {
        "/api/*": {
            "target": "${process.env.API_HTTP_CLIENT_BASE_URI}",
            "secure": false,
            "logLevel": "debug"
        }
    }
    `
    writeFile(proxyPath, proxyConfigFile, function (err) {
        if (err) {
            console.log(err);
        }
        console.log(`Output generated at ${proxyPath}`);
    });
}
