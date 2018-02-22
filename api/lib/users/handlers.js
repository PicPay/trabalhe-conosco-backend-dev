const Boom = require('boom');

exports.get = async (request) => {
  const { page, search } = request.query;
  const { db } = request.mongo;

  const coll = db.collection('users');

  const query = {};
  const limit = 15;
  const skip = (page - 1) * limit;

  if (search) {
    Object.assign(query, {
      $text: {
        $search: `"${search}"`,
        $caseSensitive: false
      }
    });
  }

  try {
    const cursor = coll.aggregate([
      { $match: query },
      { $skip: skip },
      { $limit: limit },
      {
        $lookup: {
          from: 'list_2',
          localField: 'id',
          foreignField: 'id',
          as: 'l2',
        },
      },
      { $sort: { 'l2.id': -1 } },
      {
        $lookup: {
          from: 'list_1',
          localField: 'id',
          foreignField: 'id',
          as: 'l1',
        },
      },
      { $sort: { 'l1.id': -1 } },
      { $project: { _id: 0, l1: 0, l2: 0 } },
    ]);

    const count = await coll.count(query);
    const records = await cursor.toArray();
    const meta = {
      page,
      total_pages: Math.ceil(count / limit),
      total_count: count
    };
    return Object.assign({}, { meta, records });
  } catch (e) {
    throw Boom.badImplementation();
  }
};
