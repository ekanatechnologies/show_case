```js
import { Component } from '@angular/core';
import {Endpoints} from "../../../../endpoints";
import MyLib from "../../../../../myLib";
import {Env} from "../../../../../EnvironmentVariables";
declare var $:any
@Component({
  selector: 'app-product-vendor-search',
  templateUrl: './product-vendor-search.component.html',
  styleUrls: ['./product-vendor-search.component.css']
})
export class ProductVendorSearchComponent {
  loading_data: boolean=false;
  field_location: any;
  field_search: any;
  field_range: number=5;
  private lat: number | null | undefined;
  private long: number | null | undefined;
  protected vendors: any;
  private allSubscriptions: any;
  async ngOnInit() {
    if (localStorage.getItem("ls_u_long")!==null&&localStorage.getItem("ls_u_lat")!==null){
      // @ts-ignore
      this.lat=parseFloat(localStorage.getItem("ls_u_lat"))
      // @ts-ignore
      this.long=parseFloat(localStorage.getItem("ls_u_long"))
    }
    $('#field_range').mdbRange({
      single: {
        active: true
      },
      value: {
        min: 1,
        max: 15
      }
    });

    const requestOptions = {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'token': '' + localStorage.getItem('ls_u_token')
      },
      // body: JSON.stringify(
      //   {
      //     "search":search,
      //     "location":[this.long,this.lat],
      //     "max_distance":this.field_range*1000
      //   }
      // )
    };
    fetch(Endpoints.subscription.list, requestOptions)
      .then(response => response.json())
      .then(data => {
        if (data.status) {
          this.allSubscriptions = data.response
        } else {
          MyLib.notify(false, "warning", data.response)
        }
      });

    if (localStorage.getItem('ls_u_lat') && localStorage.getItem('ls_u_long')) {
      const requestOptions = {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'token': '' + localStorage.getItem('ls_u_token')
        },
        body: JSON.stringify(
          {
            lat: localStorage.getItem('ls_u_lat'),
            lon: localStorage.getItem('ls_u_long'),
          }
        )
      };
      fetch(Endpoints.location.fetchAddress, requestOptions)
        .then(response => response.json())
        .then(data => {
          if (data.status) {
            $(".dp_text_address").text(data.response.display_name)
          } else {
            MyLib.notify(false, "warning", data.response)
          }
        });
    }
  }
  setLoction() {
    if ("geolocation" in navigator) {
      /* geolocation is available */
      navigator.geolocation.getCurrentPosition((position) => {
        // doSomething(position.coords.latitude, position.coords.longitude);
        this.field_location=position.coords.latitude+","+position.coords.longitude
        this.lat = position.coords.latitude
        this.long=position.coords.longitude

        // const requestOptions3 = {
        //   method: 'POST',
        //   headers: {
        //     'Content-Type': 'application/json',
        //     'token': '' + localStorage.getItem('ls_u_token')
        //   },
        //   body: JSON.stringify(
        //     {
        //       lat: localStorage.getItem('ls_u_lat'),
        //       lon: localStorage.getItem('ls_u_long'),
        //     }
        //   )
        // };
        // fetch(Endpoints.location.fetchAddress, requestOptions3)
        //   .then(response => response.json())
        //   .then(data => {
        //     if (data.status) {
        //       alert(data.response.display_name)
        //     } else {
        //       MyLib.notify(false, "warning", data.response)
        //     }
        //   });

        $("#div_loc").hide()
        MyLib.notify(true,'success','Location fetched successfully')
      });
    } else {
      /* geolocation IS NOT available */
      MyLib.notify(true,"warning","Location is not available pls check from your device")
    }
  }


  search(search:String) {
    this.loading_data=true
    const requestOptions = {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'token': ''+localStorage.getItem('ls_u_token')
      },
      body: JSON.stringify(
        {
          "search":search,
          "location":[this.long,this.lat],
          "max_distance":this.field_range*1000
        }
      )
    };
    fetch(Endpoints.account.searchByProduct, requestOptions)
      .then(response => response.json())
      .then(data => {
        if (data.status){
          this.vendors=data.response
        } else {
          MyLib.notify(false, "warning", data.response)
        }
        this.loading_data=false
      });
  }

  protected readonly Env = Env;
}
```
