import React from 'react';
import DataManager from '../app_data/DataManager';

export default class API {
    static url = {
        USER: '/user',
        USER_ACTIVATE: '/user/activate',
        USER_HARD_DELETE: '/user/delete',
        USER_SOFT_DELETE: '/user/soft-delete',
        USER_DEACTIVATE: '/user/deactivate',
        USER_CONFIGURATION: '/user/configuration',
        USER_CONFIGURATION_HARD_DELETE: '/user/configuration/delete',
        USER_CONFIGURATION_SOFT_DELETE: '/user/configuration/soft-delete',
        USER_CONFIGURATION_DEACTIVATE: '/user/configuration/deactivate',
        USER_AUTHORIZE: '/user/authorize',
        USER_ITS: '/user/its',
        USER_ALL: '/user/all',
        USER_LOGOUT: '/user/logout',
        USER_CONFIGURATION_SEARCH: '/user/configuration/search',
        BOARD_CONFIGURATION: '/board/configuration',
        BOARD_ITS: '/board/its',
        BOARD_ALL: '/board/all',
        BOARD_CONFIGURATION_SEARCH: '/board/configuration/search',
        USER_DEVICE_ACTIVATE: '/device/activate',
        USER_DEVICE_CONFIGURATION: '/device/configuration',
        USER_DEVICE_ITS: '/device/its',
        USER_DEVICE_ALL: '/device/all',
        USER_DEVICE_CONFIGURATION_SEARCH: '/device/configuration/search',

        USER_REGISTER_DEVICE: '/device/register',
    };

    static baseURL = {
        hot: 'http://192.168.0.148/hot/public/api',
        // hot: 'http://localhost/hot/public/api',
    };

    static defaultHeaders = {
        // 'Accept': 'application/json',
        "Content-Type": "application/json",
        "Chanel-ID": 1,
    };

    static httpMethods = {
        GET: 'GET',
        POST: 'POST',
        PUT: 'PUT',
        PATCH: 'PATCH',
        DELETE: 'DELETE',
    };

    static fetchAPI = (onSuccess, onError, url, bodyObject, additionalHeaders, method = API.httpMethods.GET, baseURL = API.baseURL.hot) => {
        let headers = JSON.parse(JSON.stringify(API.defaultHeaders));
        let status;

        let addHeaderKeys = Object.keys(additionalHeaders);
        for (let i = 0; i < addHeaderKeys.length; i++) {
            let key = addHeaderKeys[i];
            headers[key] = additionalHeaders[key];
        }

        let authorization = DataManager.getInstance().valueForKey("Authorization");
        console.log("Auth", authorization);
        if (authorization) {
            headers["Authorization"] = JSON.parse(authorization).token;
        }

        let fullURL = baseURL + url;
        let body = JSON.stringify(bodyObject);
        console.log(method);
        console.log(fullURL);
        console.log(headers);
        console.log(body);

        let params;

        if (method == API.httpMethods.GET) {
            params = {
                method: method,
                headers: headers,
            };
        } else {
            params = {
                method: method,
                headers: headers,
                body: body,
            };
        }

        fetch(fullURL, params)
            .then((response) => {
                let jsonString = JSON.stringify(response, null, 4);
                console.log(jsonString);
                status = JSON.parse(jsonString).status;
                // let json = response.json();
                // return json;
                return response.text();
            })
            .then((responseJson) => {
                console.log(responseJson);
                if (status != '200') {
                    onError(responseJson);
                } else {
                    onSuccess(responseJson);
                }
            })
            .catch((error) => {
                console.log(error);
                onError(error);
            });
    };
}
