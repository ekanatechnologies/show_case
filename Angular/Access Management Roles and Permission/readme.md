```
import { Component } from '@angular/core';
import {Endpoints} from "../../../../endpoints";
import MyLib from "../../../../../myLib";
declare var $:any
@Component({
  selector: 'app-access-management',
  templateUrl: './access-management.component.html',
  styleUrls: ['./access-management.component.css']
})
export class AccessManagementComponent {
  loading_list: boolean=true;
  protected tableData: any;
  protected permissions: any;
  field_role_title: any;
  loading_add_role: boolean=false;
  loading_update_role: boolean=false;
  field_role_id: any;
  field_role_title_upd: any;

  ngOnInit(){
    this.getPermissionList()
  }

  populateDataTable() {
    this.loading_list=true
    const requestOptions = {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'token': localStorage.getItem('ls_u_token')+'',
      },
      body: JSON.stringify({})
    };
    fetch(Endpoints.accessManagement.role.list, requestOptions)
      .then(response => response.json())
      .then(data => {
        if (data.status){
          this.tableData=data.response
          setTimeout(() =>
            {
              $('#dataTable').DataTable();
              $('.dataTables_length').addClass('bs-select');
              $('.mdb-select').materialSelect();
            },
            500);
        } else {
          MyLib.notify(false, "warning", data.response)
        }
        this.loading_list=false
      });
  }

  async getPermissionList(){
    this.loading_list=true
    const requestOptions = {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'token': localStorage.getItem('ls_u_token')+'',
      },
      body: JSON.stringify({simplify:1})
    };
    fetch(Endpoints.accessManagement.permission.list, requestOptions)
      .then(response => response.json())
      .then(data => {
        if (data.status){
          this.permissions=data.response
          this.populateDataTable()
        } else {
          MyLib.notify(false, "warning", data.response)
        }
        this.loading_list=false
      });
  }

  updateRoleHasPerm(id: any,roleCode:any) {
    let arrSelectedPerms=$("#perms_"+id).val()
    $("#btn_"+id).html("<i class='fas fa-spinner fa-pulse fa-lg bold'></i>")
    $("#btn_"+id).addClass('disabled')
    this.loading_add_role=true
    const requestOptions = {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'token': localStorage.getItem('ls_u_token')+'',
      },
      body: JSON.stringify({role:roleCode,permission:arrSelectedPerms})
    };
    fetch(Endpoints.accessManagement.roleHasPermission.update, requestOptions)
      .then(response => response.json())
      .then(data => {
        if (data.status){
          $("#tab_1").click()
          this.populateDataTable()
          MyLib.notify(true, "success", data.response)
        } else {
          MyLib.notify(false, "warning", data.response)
          $("#field_role_title").focus()
        }
        $("#btn_"+id).html("<i class=\"fa-solid fa-floppy-disk\"></i>")
        $("#btn_"+id).removeClass('disabled')
      });
  }

  createRole() {
    this.loading_add_role=true
    const requestOptions = {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'token': localStorage.getItem('ls_u_token')+'',
      },
      body: JSON.stringify({title:this.field_role_title})
    };
    fetch(Endpoints.accessManagement.role.create, requestOptions)
      .then(response => response.json())
      .then(data => {
        if (data.status){
          $("#tab_1").click()
          this.populateDataTable()
          MyLib.notify(true, "success", data.response)
        } else {
          MyLib.notify(false, "warning", data.response)
          $("#field_role_title").focus()
        }
        this.loading_add_role=false
      });
  }

  updateRole() {
    this.loading_update_role=true
    const requestOptions = {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'token': localStorage.getItem('ls_u_token')+'',
      },
      body: JSON.stringify({_id:this.field_role_id, title:this.field_role_title_upd})
    };
    fetch(Endpoints.accessManagement.role.update, requestOptions)
      .then(response => response.json())
      .then(data => {
        if (data.status){
          $("#tab_1").click()
          this.populateDataTable()
          MyLib.notify(true, "success", data.response)
        } else {
          MyLib.notify(false, "warning", data.response)
          $("#field_role_title").focus()
        }
        this.loading_update_role=false
      });
  }

  popEditable(_id: any) {
    const requestOptions = {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'token': localStorage.getItem('ls_u_token')+'',
      },
      body: JSON.stringify({_id:_id})
    };
    fetch(Endpoints.accessManagement.role.list, requestOptions)
      .then(response => response.json())
      .then(data => {
        if (data.status){
          $("#tab_3").click()
          this.field_role_id=_id
          this.field_role_title_upd=data.response[0].title

          $("#field_role_title_upd").val(this.field_role_title_upd).change()
          // console.log(data[0])
        } else {
          MyLib.notify(false, "warning", data.response)
        }
      });
  }
}
```
