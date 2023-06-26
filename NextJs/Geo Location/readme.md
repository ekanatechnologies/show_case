### Model
```js
...
location:
        {
            type: {
                type: String, // Don't do `{ location: { type: String } }`
                enum: ['Point'], // 'location.type' must be 'Point'
                default: 'Point',
                required: false
            },
            coordinates: {
                type: [Number],
                required: false,
                default:[0,0]
                /**
                 * longitude,latitude Example=>
                 * {
                 *   "type" : "Point",
                 *   "coordinates" : [
                 *     -122.5,
                 *     37.7
                 *   ]
                 * }
                 */
            }
        },
        ....
UserSchema.index({location: '2dsphere'});
const User = mongoose.model('User', UserSchema)

module.exports = {User};
 ```
### Controller
```js
const vendors = async (req, res, next) => {
    let matchData={
        active:true,
        role: 'VENDOR'
    }
    let data
    if (req.body.pincode!==undefined){
        matchData.pincodes=req.body.pincode
        data = await User.aggregate([
            {
                $match: matchData
            },
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
                $project:{name:1,images:1,address:1}
            }
        ]).exec()
        data.target=req.body.pincode
    }
    if (req.body.location!==undefined){
        data=await User.aggregate([
            {
                $geoNear: {
                    near: { type: 'Point', coordinates:req.body.location },
                    distanceField: 'distance',
                    spherical: true,
                    maxDistance: Number(req.body.max_distance),
                },
            },
            {
                $match: matchData
            },
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
                $project:{name:1,images:1,address:1,distance:1}
            },
            {
                $sort:{distance:1}
            }
        ]).exec()
        data.target=req.body.location
    }
    if (!data||data.length===0){
        res.json(myLib.sendResponse(0, "No data found"));
        return
    }
    res.json(myLib.sendResponse(1, data));
};
```
