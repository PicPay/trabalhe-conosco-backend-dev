module.exports = function follow(api, rootPath, relArray) {
	const root = api({
		method: 'GET',
		path: rootPath
	});

	return relArray.reduce(function(root, arrayItem) {
		const rel = typeof arrayItem === 'string' ? arrayItem : arrayItem.rel;
		return traverseNext(root, rel, arrayItem);
	}, root);

	function traverseNext (root, rel, arrayItem) {
	    //console.log("traverseNext root "+JSON.stringify(root)+" rel "+rel+" arrayItem "+JSON.stringify(arrayItem));
		return root.then(function (response) {
		    //console.log("response "+JSON.stringify(response));
			if (hasEmbeddedRel(response.entity, rel)) {
			    //console.log("hasEmbeddedRel response.entity "+JSON.stringify(response.entity));
				return response.entity._embedded[rel];
			}

			if(!response.entity._links) {
				return [];
			}

			if (typeof arrayItem === 'string') {
			    //console.log("arrayItem = string -> response.entity "+JSON.stringify(response.entity));
				return api({
					method: 'GET',
					path: response.entity._links[rel].href
				});
			} else {
			    //console.log("arrayItem != string -> response.entity "+JSON.stringify(response.entity));
			    //console.log("arrayItem != string -> arrayItem.params "+JSON.stringify(arrayItem.params));
				return api({
					method: 'GET',
					path: response.entity._links[rel].href,
					params: arrayItem.params
				});
			}
		});
	}

	function hasEmbeddedRel (entity, rel) {
		return entity._embedded && entity._embedded.hasOwnProperty(rel);
	}
};
