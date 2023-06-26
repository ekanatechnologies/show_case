```js
const search = async (req, res, next) => {
    // let data=await Product.find({$text: {$search: req.body.search}}).exec();
    let data=await Product.aggregate([
        {$match: {$text: {$search: req.body.search},active:{vendor:true,admin:true}}},
        {"$addFields": {"converted_id": {"$toString": "$_id"}}},
        {
            $lookup:
                {
                    from: 'files',
                    localField: 'converted_id',
                    foreignField: 'additional',
                    as: 'images',
                    pipeline: [
                        {$project: {is_local: 1, path: 1}}
                    ],
                },
        },
        {
            $lookup:
                {
                    from: 'users',
                    localField: 'created_by',
                    foreignField: '_id',
                    as: 'vendor_details',
                    pipeline: [
                        {$project: {name: 1, address: 1}}
                    ],
                },
        },
        {
            $lookup:
                {
                    from: 'domains',
                    localField: 'domain',
                    foreignField: '_id',
                    as: '_domain',
                    pipeline: [
                        {$project: {title: 1}}
                    ],
                },
        },
        {
            $lookup:
                {
                    from: 'categories',
                    localField: 'categ',
                    foreignField: '_id',
                    as: '_categ',
                },
        },
        {
            $lookup:
                {
                    from: 'subcategories',
                    localField: 'sub_categ',
                    foreignField: '_id',
                    as: '_sub_categ',
                },
        }]).project({domain: 0, categ: 0, sub_categ: 0}).exec()
    res.json(myLib.sendResponse(1,data))
};
```
