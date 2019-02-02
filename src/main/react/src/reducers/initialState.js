const initialState = {
    user: {
        users: [],             
        totalElements: 0,
        totalPages: 0,
        page: 0,
        size: 15,
        text: ''
    },
    message:{
        show: false,
        text: "",
        messageType: ""     
    }    
};

export default initialState; 